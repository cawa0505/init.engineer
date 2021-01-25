<?php

namespace App\Services\Socials\Comments;

use App\Models\Social\Cards;
use App\Services\BaseService;
use App\Exceptions\GeneralException;
use ReliqArts\Thujohn\Twitter\Facades\Twitter;
use App\Repositories\Backend\Social\CommentsRepository;
use App\Repositories\Backend\Social\MediaCardsRepository;

/**
 * Class TwitterPrimaryService.
 */
class TelegramPrimaryService extends BaseService implements SocialCardsContract
{
    /**
     * @var Twitter
     */
    protected $twitter;

    /**
     * @var CommentsRepository
     */
    protected $commentsRepository;

    /**
     * @var MediaCardsRepository
     */
    protected $mediaCardsRepository;

    /**
     * PlurkPrimaryService constructor.
     */
    public function __construct(CommentsRepository $commentsRepository, MediaCardsRepository $mediaCardsRepository)
    {
        $this->commentsRepository = $commentsRepository;
        $this->mediaCardsRepository = $mediaCardsRepository;
    }

    /**
     * @param Cards $cards
     * @return
     */
    public function getComments(Cards $cards)
    {
        // TODO: ...
    }

    /**
     * @param array $data
     */
    private function write(array $data)
    {
        // TODO: ...
    }
}
