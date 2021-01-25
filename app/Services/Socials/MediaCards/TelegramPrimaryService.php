<?php

namespace App\Services\Socials\MediaCards;

use Exception;
use App\Models\Auth\User;
use App\Models\Social\Cards;
use App\Services\BaseService;
use App\Exceptions\GeneralException;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Repositories\Backend\Social\MediaCardsRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

/**
 * Class TelegramPrimaryService.
 */
class TelegramPrimaryService extends BaseService implements SocialCardsContract
{
    /**
     * @var MediaCardsRepository
     */
    protected $mediaCardsRepository;

    /**
     * TelegramPrimaryService constructor.
     */
    public function __construct(MediaCardsRepository $mediaCardsRepository)
    {
        $this->mediaCardsRepository = $mediaCardsRepository;
    }

    /**
     * @param Cards $cards
     * @return MediaCards
     */
    public function publish(Cards $cards)
    {
        if ($this->mediaCardsRepository->findByCardId($cards->id, 'telegram', 'primary'))
        {
            throw new GeneralException(__('exceptions.backend.social.media.cards.repeated_error'));
        }
        else
        {
            try
            {
                $response = Telegram::sendPhoto([
                    'chat_id' => config('social.telegram.primary.user_id'), 
                    'photo' => $cards->images->first()->getPicture(), 
                    'caption' => $this->buildContent($cards->content, [
                        'id' => $cards->id,
                        'hashtags' => $cards->metadata['hashtags'] ?? [],
                    ])
                  ]);
                
                return $this->mediaCardsRepository->create([
                    'card_id' => $cards->id,
                    'model_id' => $cards->model_id,
                    'social_type' => 'telegram',
                    'social_connections' => 'primary',
                    'social_card_id' => $response['message_id'],
                ]);
            }
            catch (Exception $e)
            {
                \Log::error($e->getMessage());
            }
        }
    }

    /**
     * @param Cards $cards
     * @return MediaCards
     */
    public function update(Cards $cards)
    {
        if ($mediaCards = $this->mediaCardsRepository->findByCardId($cards->id, 'telegram', 'primary'))
        {
            try
            {
                $response = Telegram::getTweet($mediaCards->social_card_id);
                return $this->mediaCardsRepository->update($mediaCards, [
                    'num_like' => $response->favorite_count,
                    'num_share' => $response->retweet_count,
                ]);
            }
            catch (Exception $e)
            {
                \Log::error($e->getMessage());
            }
        }

        return false;
    }

    /**
     * @param User  $user
     * @param Cards $cards
     * @param array $options
     * @return MediaCards
     */
    public function destory(User $user, Cards $cards, array $options)
    {
        if ($mediaCards = $this->mediaCardsRepository->findByCardId($cards->id, 'telegram', 'primary'))
        {
            try
            {
                // Delete Photo not working.
                $request = sprintf("https://api.telegram.org/bot%s/deleteMesaage?chat_id=%s&message_id=%d", 
                                    config('telegram.bot_token'),
                                    config('social.telegram.primary.user_id'),
                                    $mediaCards->social_card_id
                            );
                            dd($request);
                // $response = Telegram::deleteMessage($mediaCards->social_card_id);
                $http = new Client();
                $response = $http->get($request);
                dd($response);
                $data = json_decode($response->getBody());

                // TODO: 解析 response 的資訊

                return $this->mediaCardsRepository->update($mediaCards, [
                    'active' => false,
                    'is_banned' => true,
                    'banned_user_id' => $user->id,
                    'banned_remarks' => isset($options['remarks'])? $options['remarks'] : null,
                    'banned_at' => now(),
                ]);
            }
            catch (\Facebook\Exceptions\FacebookSDKException $e)
            {
                \Log::error($e->getMessage());
            }
            catch (Exception $e)
            {
                \Log::error($e->getMessage());
            }
        }

        return false;
    }

    /**
     * 注意: Telegram 採用 sendPhoto 時，其圖片 Caption 字元長度為 0-1024。
     *
     * @param string $content
     * @return string
     */
    public function buildContent($content = '', array $options = [])
    {
        $options['hashtags'][] = '#情緒泥巴YKLM' .  base_convert($options['id'], 10, 36);
        $addtags = implode(' ', $options['hashtags']);

        // $_content = (mb_strlen($content, 'utf-8') > 20)? mb_substr($content, 0, 20, 'utf-8') . ' ...' : $content;
        $_content = Str::limit($content, 200, ' ...');

        return $addtags . "\n\r----------\n\r" .
            $_content . "\n\r----------\n\r" .
            '📢 [匿名發文] ' . route('frontend.social.cards.create') . "\n\r";

        // return $addtags . "\n\r----------\n\r" .
        //     $_content . "\n\r----------\n\r" .
        //     '🗳️ [群眾審核] ' . route('frontend.social.cards.review') . "\n\r" .
        //     '👉 [GitHub] https://github.com/yklmbbs/mood.schl' . "\n\r" .
        //     '📢 [匿名發文] ' . route('frontend.social.cards.create') . "\n\r" .
        //     '🥙 [全平台留言] ' . route('frontend.social.cards.show', ['id' => $options['id']]);

        // return sprintf(
        //     "#純靠北工程師%s\r\n%s\r\n%s\r\n📢 匿名發文請至 %s\r\n🥙 全平台留言 %s",
        //     base_convert($options['id'], 10, 36),
        //     $_content,
        //     '👉 去 GitHub 給我們🌟用行動支持純靠北工程師 https://github.com/init-engineer/init.engineer',
        //     route('frontend.social.cards.create'),
        //     route('frontend.social.cards.show', ['id' => $options['id']])
        // );
    }
}
