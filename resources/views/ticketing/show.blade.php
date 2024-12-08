@extends('layouts.admin')

@push('css')

@endpush

@section('main-content')

    <h1 class="h3 mb-4 text-gray-800">{{ __('Ticket Details') }}</h1>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet distinctio nostrum officia deserunt excepturi porro, quod vero culpa sequi quaerat repellat tenetur recusandae cupiditate officiis maxime perferendis ex vitae? Enim.</p>

    <div class="row">
        <!-- Ticket Details Card -->
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-ticket-alt mr-2"></i>Ticket Information
                    </h6>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#solvedModal"><i class="fas fa-check-circle"></i>
                        Solved Ticket
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-6">Title:</dt>
                                <dd class="col-6">{{ $tickets->title }}</dd>

                                <dt class="col-6">Status:</dt>
                                <dd class="col-6">
                                    <span class="badge badge-{{ $tickets->badgeClass }} text-capitalize">
                                        {{ $tickets->status }}
                                    </span>
                                </dd>

                                <dt class="col-6">Priority:</dt>
                                <dd class="col-6">
                                    <span class="badge badge-{{ $tickets->priorityClass }} text-capitalize">
                                        {{ $tickets->priority }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-6">Assigned To:</dt>
                                <dd class="col-6">{{ $tickets->assignedTo->name ?? 'Unassigned' }}</dd>

                                <dt class="col-6">Created By:</dt>
                                <dd class="col-6">{{ $tickets->user->name }}</dd>

                                <dt class="col-6">Created At:</dt>
                                <dd class="col-6">{{ $tickets->created_at->format('d M Y') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr>

                    <h6 class="font-weight-bold mb-3">Description</h6>
                    <div class="card bg-light p-3">
                        <p class="text-gray-800 mb-0">{{ $tickets->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Comments Section -->
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-gradient-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-comments mr-2"></i>Comments
                    </h6>
                    <span class="badge badge-light text-dark">
                        {{ $tickets->comments->count() }} Comments
                    </span>
                </div>
                <div class="card-body">
                    <!-- Comment List -->
                    <div class="comments-container" style="max-height: 350px; overflow-y: auto;">
                        @forelse ($tickets->comments as $comment)
                            <div class="media mb-3 p-3 bg-light rounded">
                                <img class="mr-3 rounded-circle" src="https://ui-avatars.com/api/?name={{ $comment->user->name }}"
                                    alt="{{ $comment->user->name }}" width="45" height="45">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1 font-weight-bold">
                                        {{ $comment->user->name }}
                                        <small class="text-muted ml-2">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </small>
                                    </h6>
                                    <p class="mb-0 text-gray-800">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center" role="alert">
                                <i class="fas fa-info-circle mr-2"></i>No comments yet
                            </div>
                        @endforelse
                    </div>

                    <!-- Add Comment Form -->
                    <form action="" method="POST" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="comment" class="font-weight-bold">Add a Comment</label>
                            <textarea id="comment" name="comment" class="form-control @error('comment') is-invalid @enderror" rows="3" placeholder="Write your comment here..."required></textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane mr-1"></i>Submit Comment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if ($tickets->status == 'Closed')
        <!-- Solved ticket Section --> 
        <div class="col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-gradient-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-ticket-alt mr-2"></i>Solved Ticket
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-gray-800 mb-0">
                        {{ $tickets->solved_ticket }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>

@endsection

@push('scripts')

@endpush
