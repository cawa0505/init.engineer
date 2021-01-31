<?php

namespace App\Http\Controllers\Api\Frontend\Social\Cards;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Social\Cards;

use App\Services\Socials\Cards\CardsService;
use App\Services\Socials\Images\ImagesService;

use App\Http\Controllers\Controller;

use App\Http\Transformers\IlluminatePaginatorAdapter;
use App\Http\Transformers\Social\CardsTransformer;
use App\Http\Transformers\Social\CommentsTransformer;
use App\Http\Transformers\Social\MediaCardsTransformer;
use App\Http\Transformers\Social\DashboardCardsTransformer;

use App\Http\Requests\Api\Frontend\Social\Cards\DashboardRequest;
use App\Http\Requests\Api\Frontend\Social\Cards\StoreCardsRequest;

use App\Repositories\Frontend\Social\CardsRepository;
use App\Repositories\Frontend\Social\ImagesRepository;
use App\Repositories\Frontend\Social\CommentsRepository;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class CardsController.
 */
class CardsController extends Controller
{
    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * @var CardsService
     */
    protected $cardsService;

    /**
     * @var ImagesService
     */
    protected $imagesService;

    /**
     * @var CardsRepository
     */
    protected $cardsRepository;

    /**
     * @var ImagesRepository
     */
    protected $imagesRepository;

    /**
     * @var CommentsRepository
     */
    protected $commentsRepository;

    /**
     * CardsController constructor.
     *
     * @param Manager $fractal
     * @param CardsService $cardsService
     * @param ImagesService $imagesService
     * @param CardsRepository $cardsRepository
     * @param ImagesRepository $imagesRepository
     * @param CommentsRepository $commentsRepository
     */
    public function __construct(
        Manager $fractal,
        CardsService $cardsService,
        ImagesService $imagesService,
        CardsRepository $cardsRepository,
        ImagesRepository $imagesRepository,
        CommentsRepository $commentsRepository
    ) {
        $this->fractal = $fractal;
        $this->cardsService = $cardsService;
        $this->imagesService = $imagesService;
        $this->cardsRepository = $cardsRepository;
        $this->imagesRepository = $imagesRepository;
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->cardsRepository->getActivePaginated();
        $cards = new Collection($paginator->items(), new CardsTransformer());
        $cards->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }

    /**
     * @param DashboardRequest $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(DashboardRequest $request)
    {
        $paginator = $this->cardsRepository->getDashboardPaginated($request->user());
        $cards = new Collection($paginator->items(), new DashboardCardsTransformer());
        $cards->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCardsRequest $request
     * @param ImagesService $imagesService
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardsRequest $request)
    {
        $modelCard = $this->cardsRepository->create([
            'model_id' => $request->user()->id,
            'content' => $request->input('content'),
            'metadata' => ['hashtags' => [$request->input('hashtag')]],
        ]);

        if ($request->has('avatar')) {
            $avatar = $this->imagesService->uploadImage([], $request->file('avatar'));
        } else if ($request->has('base64')) {
            $base64File = $request->input('base64');
            $extension = explode('/', mime_content_type($base64File))[1];
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));
            $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString() . '.' . $extension;
            file_put_contents($tmpFilePath, $fileData);
            $tmpFile = new File($tmpFilePath);
            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true // Mark it as test, since the file isn't from real HTTP POST.
            );
            $file->store('avatar');
            $avatar = $this->imagesService->uploadImage([], $file);
        } else {
            $avatar = $this->imagesService->buildImage($request->only('content', 'themeStyle', 'fontStyle', 'isFeatureToBeCoutinued'), $modelCard);
        }

        $this->imagesRepository->create([
            'card_id' => $modelCard->id,
            'model_id' => $request->user()->id,
            'avatar' => [
                'path' => $avatar['avatar']['path'],
                'name' => $avatar['avatar']['name'],
                'type' => $avatar['avatar']['type'],
            ],
        ]);

        $this->cardsService->creationNotify($modelCard);

        $cards = new Item($modelCard, new CardsTransformer());
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param Cards $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cards $id)
    {
        $cards = new Item($id->isPublish() ? $id : null, new CardsTransformer());
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }

    /**
     * @param Cards $id
     * @return \Illuminate\Http\Response
     */
    public function links(Cards $id)
    {
        $medias = $id->medias->reject(function ($media) {
            return $media->isPublish();
        });
        $cards = new Collection($medias, new MediaCardsTransformer());
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }

    /**
     * @param Cards $id
     * @return \Illuminate\Http\Response
     */
    public function comments(Cards $id)
    {
        $paginator = $this->commentsRepository->getActivePaginated($id);
        $comments = new Collection($paginator->items(), new CommentsTransformer());
        $comments->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $response = $this->fractal->createData($comments);

        return response()->json($response->toArray());
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function qrcode(Request $request)
    {
        $image = QrCode::format('png')
                        ->margin(2)->size(180)->errorCorrection('H')
                        ->merge(public_path('img/frontend/cards/avataaars.png'), .3, true)
                        ->color(0, 0, 0, 55)
                        ->eye('circle')
                        // ->color(150,90,10)->backgroundColor(10,14,244)
                        ->Style('round')->generate(env('APP_URL'));

        return response()->json("data:image/png;base64," . base64_encode($image));

    }

}
