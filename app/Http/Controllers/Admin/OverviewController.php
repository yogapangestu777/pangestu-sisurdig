<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\IncomingLetterService;
use App\Services\OutgoingLetterService;
use App\Services\PartyService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class OverviewController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected CategoryService $categoryService,
        protected PartyService $partyService,
        protected IncomingLetterService $incomingLetterService,
        protected OutgoingLetterService $outgoingLetterService
    ) {}

    public function index(): View
    {
        $forCards = [
            [
                'title' => 'Pengguna',
                'data' => $this->userService->countUser(),
                'id' => 'user-count',
                'url' => route('admin.manage.users.index'),
                'icon' => 'user-check',
                'outline' => 'outline-success',
            ],
            [
                'title' => 'Kategori',
                'data' => $this->categoryService->countCategory(),
                'id' => 'topic-count',
                'url' => route('admin.master.categories.index'),
                'icon' => 'list',
                'outline' => 'outline-blue',
            ],
            [
                'title' => 'Pihat Terkait',
                'data' => $this->partyService->countParty(),
                'id' => 'unit-count',
                'url' => route('admin.master.parties.index'),
                'icon' => 'users',
                'outline' => 'outline-indigo',
            ],
            [
                'title' => 'Surat Masuk',
                'data' => $this->incomingLetterService->countIncomingLetter(),
                'id' => 'lga-count',
                'url' => route('admin.manage.incomingLetters.index'),
                'icon' => 'inbox-in',
                'outline' => 'outline-purple',
            ],
            [
                'title' => 'Surat Keluar',
                'data' => $this->outgoingLetterService->countOutgoingLetter(),
                'id' => 'profile-count',
                'url' => route('admin.manage.outgoingLetters.index'),
                'icon' => 'inbox-out',
                'outline' => 'outline-pink',
            ],
        ];

        $mostFrequentLetterParty = $this->outgoingLetterService->getMostFrequentLetterParty();

        return view('pages.admin.overview.index', [
            'pageTitle' => 'Ikhtisar',
            'pageDescription' => 'Halaman ini memberikan ringkasan data dan metrik utama untuk membantu administrator dalam memantau dan menganalisis kinerja sistem.',
            'forCards' => $forCards,
            'mostFrequentLetterParty' => $mostFrequentLetterParty,
        ]);
    }

    public function getDataByTime(string $time): JsonResponse
    {
        $dateQuery = match ($time) {
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            'year' => [now()->startOfYear(), now()->endOfYear()],
            'all-time' => null,
            default => null,
        };

        $forCards = [
            [
                'title' => 'Pengguna',
                'data' => $this->userService->countUser($dateQuery),
                'id' => 'user-count',
                'url' => route('admin.manage.users.index'),
                'icon' => 'user-check',
                'outline' => 'outline-success',
            ],
            [
                'title' => 'Kategori',
                'data' => $this->categoryService->countCategory($dateQuery),
                'id' => 'topic-count',
                'url' => route('admin.master.categories.index'),
                'icon' => 'list',
                'outline' => 'outline-blue',
            ],
            [
                'title' => 'Pihat Terkait',
                'data' => $this->partyService->countParty($dateQuery),
                'id' => 'unit-count',
                'url' => route('admin.master.parties.index'),
                'icon' => 'users',
                'outline' => 'outline-indigo',
            ],
            [
                'title' => 'Surat Masuk',
                'data' => $this->incomingLetterService->countIncomingLetter($dateQuery),
                'id' => 'lga-count',
                'url' => route('admin.manage.incomingLetters.index'),
                'icon' => 'inbox-in',
                'outline' => 'outline-purple',
            ],
            [
                'title' => 'Surat Keluar',
                'data' => $this->outgoingLetterService->countOutgoingLetter($dateQuery),
                'id' => 'profile-count',
                'url' => route('admin.manage.outgoingLetters.index'),
                'icon' => 'inbox-out',
                'outline' => 'outline-pink',
            ],
        ];

        $mostFrequentLetterParty = $this->outgoingLetterService->getMostFrequentLetterParty($dateQuery);

        return response()->json([
            'status' => true,
            'message' => 'Successfully retrieved data',
            'data' => [
                'forCards' => view('pages.admin.overview.count-data-content', compact('forCards'))->render(),
                'mostFrequentLetterParty' => view('pages.admin.overview.most-frequent-letter-party-content', compact('mostFrequentLetterParty'))->render(),
            ],
        ], 200);
    }
}
