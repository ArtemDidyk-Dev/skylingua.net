<?php

namespace App\Services;
use App\DTO\FaqDTO;
use App\Models\Faq\Faq;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class FaqService implements FaqInterface
{
    protected FaqRepositoryInterface $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function all(): Collection
    {
        return $this->faqRepository->all();
    }

    public function create_update(FaqDTO $dto, ?Model $faq = null)
    {
        return (is_null($faq) ? $this->faqRepository->create($dto) : $this->faqRepository->update($dto, $faq));
    }


    public function deleteThroughId(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->faqRepository->delete($this->faqRepository->findId($id));
            return response()->json(['success' => true], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false], Response::HTTP_BAD_REQUEST);
        }
    }


}
