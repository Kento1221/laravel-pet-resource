<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\Enum\PetStatus;
use App\Domain\Mapper\PetRequestDataMapper;
use App\Http\Requests\PetDataRequest;
use App\Http\Requests\PetStatusRequest;
use App\Repository\CategoryRepository;
use App\Repository\PetRepository;
use App\Repository\TagRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PetController extends Controller
{
    public function __construct(
        protected PetRepository        $petRepository,
        protected TagRepository        $tagRepository,
        protected CategoryRepository   $categoryRepository,
        protected PetRequestDataMapper $petDataMapper,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(PetStatusRequest $request): \Illuminate\Contracts\View\View
    {
        return view('index', [
            'pets' => $this->petRepository->getPetDataForStatus(
                $request->has('status')
                    ? PetStatus::from($request->validated('status'))
                    : PetStatus::pending)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('create', [
            'tags'       => $this->tagRepository->getAllTags(),
            'categories' => $this->categoryRepository->getAllCategories(),
            'statuses'   => collect(
                array_map(fn($status) => [
                    'id'       => $status->value,
                    'name'     => ucfirst($status->value),
                    'selected' => $status === PetStatus::pending
                ], PetStatus::cases())),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetDataRequest $request): \Illuminate\Http\RedirectResponse
    {
        $success = $this->petRepository->createPet(
            $this->petDataMapper->map($request, id: Carbon::now()->timestamp)
        );

        return redirect()->route('pet.index', [
            'status' => $request->validated('status')
        ])->with([
            'status' => $success
                ? 'The pet has been created successfully!'
                : 'Sorry, the pet could not be created.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): \Illuminate\Contracts\View\View
    {
        return view('show', [
            'petData' => $this->petRepository->getPetData($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): \Illuminate\Contracts\View\View
    {
        return view('edit', [
            'petData'    => $this->petRepository->getPetData($id),
            'tags'       => $this->tagRepository->getAllTags(),
            'categories' => $this->categoryRepository->getAllCategories(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PetDataRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $success = $this->petRepository->updatePet(
            $this->petDataMapper->map(
                $request, $id
            )
        );

        return redirect()->route('pet.show', $id)->with([
            'status' => $success
                ? 'The pet has been edited successfully!'
                : 'Sorry, the pet could not be edited.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $success = $this->petRepository->deletePet($id);

        if ($request->ajax()) {
            Session::flash('status', $success
                ? 'Pet removed successfully!'
                : 'Sorry, the pet could not be removed.');

            return response()->json(['success' => $success]);
        }

        return redirect()->back()->with([
            'status' => $success
                ? 'Pet removed successfully!'
                : 'Sorry, the pet could not be removed.'
        ]);

    }
}
