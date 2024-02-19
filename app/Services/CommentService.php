<?php

namespace App\Services;
use App\DTO\CommentDTO;
use App\Models\Comment\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class CommentService implements CommentInterface
{
    protected CommentRepositoryInterface $commentRepository;
    protected SaveFile $saveFile;
    public function __construct(CommentRepositoryInterface $commentRepository, SaveFile $saveFile)
    {
        $this->saveFile = $saveFile;
        $this->commentRepository = $commentRepository;
    }

    public function all(): Collection
    {
        return $this->commentRepository->all();
    }

    public function create_update(CommentDTO $dto, ?Model $comment = null)
    {

        $dto->image = $this->saveFile->save($dto->image);

        return (is_null($comment) ? $this->commentRepository->create($dto) : $this->commentRepository->update($dto, $comment));
    }


    public function deleteThroughId(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->commentRepository->delete($this->commentRepository->findId($id));
            return response()->json(['success' => true], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
        }
    }


}
