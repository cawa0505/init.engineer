<?php

namespace App\Http\Controllers\Api\Backend\Social\Cards;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Http\Controllers\Controller;
use App\Services\Socials\Cards\CardsService;
use App\Services\Socials\Images\ImagesService;
use App\Http\Transformers\Social\CardsTransformer;
use App\Repositories\Frontend\Social\CardsRepository;
use App\Repositories\Frontend\Social\ImagesRepository;
use App\Http\Requests\Api\Backend\Social\Cards\StoreCardsRequest;

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
     * CardsController constructor.
     *
     * @param Manager $fractal
     * @param CardsService $cardsService
     * @param ImagesService $imagesService
     * @param CardsRepository $cardsRepository
     * @param ImagesRepository $imagesRepository
     */
    public function __construct(
        Manager $fractal,
        CardsService $cardsService,
        ImagesService $imagesService,
        CardsRepository $cardsRepository,
        ImagesRepository $imagesRepository)
    {
        $this->fractal = $fractal;
        $this->cardsService = $cardsService;
        $this->imagesService = $imagesService;
        $this->cardsRepository = $cardsRepository;
        $this->imagesRepository = $imagesRepository;
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
            'active' => true,
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
            $avatar = $this->imagesService->buildImage($request->only('content', 'themeStyle', 'fontStyle', 'isFeatureToBeCoutinued', 'isManagerLine'), $modelCard);
        }
        
        // $avatar = $request->has('avatar')?
        //     $this->imagesService->uploadImage([], $request->file('avatar')) :
        //     $this->imagesService->buildImage($request->only('content', 'themeStyle', 'fontStyle', 'isFeatureToBeCoutinued', 'isManagerLine'));

        $this->imagesRepository->create([
            'card_id' => $modelCard->id,
            'model_id' => $request->user()->id,
            'avatar' => [
                'path' => $avatar['avatar']['path'],
                'name' => $avatar['avatar']['name'],
                'type' => $avatar['avatar']['type'],
            ],
        ]);

        $this->cardsService->publish($modelCard);
        $this->cardsService->publishNotify($modelCard);

        $cards = new Item($modelCard, new CardsTransformer());
        $response = $this->fractal->createData($cards);

        return response()->json($response->toArray());
    }
}
