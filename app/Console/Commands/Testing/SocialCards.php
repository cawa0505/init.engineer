<?php

namespace App\Console\Commands\Testing;

use App\Models\Auth\User;
use App\Models\Social\Cards;
use Illuminate\Console\Command;
use App\Services\Socials\Comments\PlurkPrimaryService as PlurkPrimaryCommentsService;
use App\Services\Socials\MediaCards\PlurkPrimaryService as PlurkPrimaryMediaCardsService;
use App\Services\Socials\Comments\TwitterPrimaryService as TwitterPrimaryCommentsService;
use App\Services\Socials\MediaCards\TwitterPrimaryService as TwitterPrimaryMediaCardsService;
use App\Services\Socials\Comments\TelegramPrimaryService as TelegramPrimaryCommentsService;
use App\Services\Socials\MediaCards\TelegramPrimaryService as TelegramPrimaryMediaCardsService;
use App\Services\Socials\Comments\TumblrPrimaryService as TumblrPrimaryCommentsService;
use App\Services\Socials\MediaCards\TumblrPrimaryService as TumblrPrimaryMediaCardsService;
use App\Services\Socials\Comments\FacebookPrimaryService as FacebookPrimaryCommentsService;
use App\Services\Socials\MediaCards\FacebookPrimaryService as FacebookPrimaryMediaCardsService;
use App\Services\Socials\Comments\FacebookSecondaryService as FacebookSecondaryCommentsService;
use App\Services\Socials\MediaCards\FacebookSecondaryService as FacebookSecondaryMediaCardsService;

/**
 * Class SocialCards.
 */
class SocialCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testing:social-cards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[測試] 社群平台發文';

    /**
     * @var App\Services\Socials\Comments\PlurkPrimaryService
     */
    protected $plurkPrimaryCommentsService;

    /**
     * @var App\Services\Socials\Comments\TwitterPrimaryService
     */
    protected $twitterPrimaryCommentsService;

    /**
     * @var App\Services\Socials\Comments\TelegramPrimaryService
     */
    protected $telegramPrimaryCommentsService;

    /**
     * @var App\Services\Socials\Comments\TumblrPrimaryService
     */
    protected $tumblrPrimaryCommentsService;

    /**
     * @var App\Services\Socials\Comments\FacebookPrimaryService
     */
    protected $facebookPrimaryCommentsService;

    /**
     * @var App\Services\Socials\Comments\FacebookSecondaryService
     */
    protected $facebookSecondaryCommentsService;

    /**
     * @var App\Services\Socials\MediaCards\PlurkPrimaryService
     */
    protected $plurkPrimaryMediaCardsService;

    /**
     * @var App\Services\Socials\MediaCards\TwitterPrimaryService
     */
    protected $twitterPrimaryMediaCardsService;

    /**
     * @var App\Services\Socials\MediaCards\TelegramPrimaryService
     */
    protected $telegramPrimaryMediaCardsService;

    /**
     * @var App\Services\Socials\MediaCards\TumblrPrimaryService
     */
    protected $tumblrPrimaryMediaCardsService;

    /**
     * @var App\Services\Socials\MediaCards\FacebookPrimaryService
     */
    protected $facebookPrimaryMediaCardsService;

    /**
     * @var App\Services\Socials\MediaCards\FacebookSecondaryService
     */
    protected $facebookSecondaryMediaCardsService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        PlurkPrimaryCommentsService $plurkPrimaryCommentsService,
        PlurkPrimaryMediaCardsService $plurkPrimaryMediaCardsService,
        TwitterPrimaryCommentsService $twitterPrimaryCommentsService,
        TwitterPrimaryMediaCardsService $twitterPrimaryMediaCardsService,
        TelegramPrimaryCommentsService $telegramPrimaryCommentsService,
        TelegramPrimaryMediaCardsService $telegramPrimaryMediaCardsService,
        TumblrPrimaryCommentsService $tumblrPrimaryCommentsService,
        TumblrPrimaryMediaCardsService $tumblrPrimaryMediaCardsService,
        FacebookPrimaryCommentsService $facebookPrimaryCommentsService,
        FacebookPrimaryMediaCardsService $facebookPrimaryMediaCardsService,
        FacebookSecondaryCommentsService $facebookSecondaryCommentsService,
        FacebookSecondaryMediaCardsService $facebookSecondaryMediaCardsService)
    {
        parent::__construct();

        $this->plurkPrimaryCommentsService = $plurkPrimaryCommentsService;
        $this->plurkPrimaryMediaCardsService = $plurkPrimaryMediaCardsService;
        $this->twitterPrimaryCommentsService = $twitterPrimaryCommentsService;
        $this->twitterPrimaryMediaCardsService = $twitterPrimaryMediaCardsService;
        $this->telegramPrimaryCommentsService = $telegramPrimaryCommentsService;
        $this->telegramPrimaryMediaCardsService = $telegramPrimaryMediaCardsService;
        $this->tumblrPrimaryCommentsService = $tumblrPrimaryCommentsService;
        $this->tumblrPrimaryMediaCardsService = $tumblrPrimaryMediaCardsService;
        $this->facebookPrimaryCommentsService = $facebookPrimaryCommentsService;
        $this->facebookPrimaryMediaCardsService = $facebookPrimaryMediaCardsService;
        $this->facebookSecondaryCommentsService = $facebookSecondaryCommentsService;
        $this->facebookSecondaryMediaCardsService = $facebookSecondaryMediaCardsService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $user = User::find(1);
        $cards = Cards::find(109);

        // Cards::all()->each(function($card) {
        //     $this->facebookPrimaryMediaCardsService->publish($card);
        // });

        // Cards::whereDoesntHave("medias", function($subQuery) {
        //     $subQuery->where("social_type", 'facebook')
        //             ->where("social_connections", 'primary');
        //     })->get()->each(function($card) {
        //         $this->facebookPrimaryMediaCardsService->publish($card);
        //     });

        /**
         * 測試發表文章到社群平台
         */
        // $this->tumblrPrimaryMediaCardsService->publish($cards);
        // $this->plurkPrimaryMediaCardsService->publish($cards);
        // $this->telegramPrimaryMediaCardsService->publish($cards);
        // $this->twitterPrimaryMediaCardsService->publish($cards);
        $this->facebookPrimaryMediaCardsService->publish($cards);
        // $this->facebookSecondaryMediaCardsService->publish($cards);

        /**
         * 測試更新文章的 Likes、分享數
         */
        // $this->tumblrPrimaryMediaCardsService->update($cards);
        // $this->plurkPrimaryMediaCardsService->update($cards);
        // $this->telegramPrimaryMediaCardsService->update($cards);
        // $this->twitterPrimaryMediaCardsService->update($cards);
        // dd($this->facebookPrimaryMediaCardsService->update($cards));
        // dd($this->facebookSecondaryMediaCardsService->update($cards));

        /**
         * 測試更新文章的留言
         */
        // $this->tumblrPrimaryCommentsService->getComments($cards);
        // $this->plurkPrimaryCommentsService->getComments($cards);
        // $this->twitterPrimaryCommentsService->getComments($cards);
        // $this->facebookPrimaryCommentsService->getComments($cards);
        // $this->facebookSecondaryCommentsService->getComments($cards);

        /**
         * 測試刪除社群平台的文章
         */
        // $this->tumblrPrimaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
        // $this->telegramPrimaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
        // $this->plurkPrimaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
        // $this->twitterPrimaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
        // $this->facebookPrimaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
        // $this->facebookSecondaryMediaCardsService->destory($user, $cards, ['remarks' => '刪除測試文章。']);
    }
}
