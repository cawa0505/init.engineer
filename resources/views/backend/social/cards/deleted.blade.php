@extends('backend.layouts.app')

@section('title', __('labels.backend.social.cards.management') . ' | ' . __('labels.backend.social.cards.deleted'))

@section('breadcrumb-links')
    @include('backend.social.cards.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('labels.backend.social.cards.management')
                    <small class="text-muted">@lang('labels.backend.social.cards.deleted')</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('labels.backend.social.cards.table.id')</th>
                                <th>@lang('labels.backend.social.cards.table.user')</th>
                                <th>@lang('labels.backend.social.cards.table.content')</th>
                                <th>@lang('labels.backend.social.cards.table.last_updated')</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($cards->count())
                                @foreach ($cards as $card)
                                    <tr>
                                        <td><h4><span class="badge badge-dark" data-toggle="tooltip" data-placement="top" title="ID: {{ $card->id }}">#{{ app_name() . base_convert($card->id, 10, 36) }}</span></h4></td>
                                        @if (isset($card->model))
                                            <td>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <img class="media-object img-fluid rounded mr-1" src="{{ $card->model->getPicture() }}" style="max-width: 48px;max-height: 48px;" alt="{{ $card->model->email }}">
                                                    </div>
                                                    <div class="media-body p-0">
                                                        <h4 class="media-heading">{{ $card->model->full_name }}</h4>
                                                        <p>{{ $card->model->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td style="max-width: 24rem;">
                                            <div class="media">
                                                <div class="media-left">
                                                @if ($card->images->first())
                                            <img class="media-object img-fluid rounded mr-1" data-toggle="tooltip"
                                                data-placement="bottom" title="{{ $card->content }}"
                                                src="{{ $card->images->first()->getPicture() ?? asset('img/frontend/default-image.png') }}"
                                                style="max-width: 128px;max-height: 128px;" alt="{{ $card->content }}">
                                            @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $card->updated_at->diffForHumans() }}</td>
                                        <td>@include('backend.social.cards.includes.actions', ['card' => $card])</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="9"><p class="text-center">@lang('strings.backend.social.cards.no_deleted')</p></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $cards->total() !!} {{ trans_choice('labels.backend.social.cards.table.total', $cards->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $cards->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
