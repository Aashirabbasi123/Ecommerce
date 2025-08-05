@extends('layouts.admin')

@section('content')
    <div class="main-content-inner ">
        <div class="main-content-wrap">
            @if (session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slider</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Slider</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" required>
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.add_slider') }}">
                        <i class="icon-plus"></i>Add new
                    </a>
                </div>

                <div class="wg-table table-all-user" style="max-height: 400px; overflow-y: auto; overflow-x: auto; border: 1px solid #e0e0e0; border-radius: 8px; padding: 10px;">
                    <table class="table table-striped table-bordered" style="min-width: 1000px; width: 100%;">
                        <thead style="position: sticky; top: 0; background: #f9f9f9;" >
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Tagline</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slides as $slide)
                                <tr>
                                    <td>{{ $slide->id }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/slides/' . $slide->image) }}"
                                                alt="{{ $slide->title }}" class="image">
                                        </div>
                                    </td >
                                    <td>{{ $slide->tagline }}</td>
                                    <td>{{ $slide->title }}</td>
                                    <td>{{ $slide->subtitle }}</td>
                                    <td class="flex gap-2 items-center justify-center">{{ $slide->link }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href={{ route('admin.slide.edit', ['id' => $slide->id]) }}>
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.slide.delete', $slide->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="item text-danger delete"
                                                    onclick="return confirm('Are you sure to delete this?')">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $slides->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
