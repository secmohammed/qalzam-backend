<?php
namespace App\Domain\Message\Pipelines;

use Carbon\Carbon;
use App\Common\Entities\Queue;
use App\Infrastructure\Pipelines\Pipeline;

class ModifyBrodcastingMessageDelay implements Pipeline
{
    /**
     * @var mixed
     */
    private $queue;

    /**
     * @param Queue $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @param $request
     * @param \Closure $next
     */
    public function handle($data, \Closure $next)
    {
        ['message' => $message, 'request' => $request] = $data;
        if (!$request->delay) {
            return $next($message);
        }
        try {
            $queue = $this->queue->where(['available_at' => strtotime(Carbon::parse($message->delay)->format('Y-m-d H:i:s'))])->firstOrFail();

            $command = unserialize($queue->payload['data']['command']);
            $command->delay = Carbon::parse($request->delay);
            $payload = $queue->payload;
            $payload['data']['command'] = serialize($command);
            $queue->update([
                'payload' => $payload,
            ]);

            return $next($message);

        } catch (\Exception $e) {
            return $next($message);
        }
    }
}
