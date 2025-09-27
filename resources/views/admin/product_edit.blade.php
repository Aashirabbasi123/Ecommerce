@extends('layouts.admin')
@section('content')
    <div class="main-content py-10 px-4 bg-gray-100 min-h-screen">
        <!-- main-content-wrap -->
        <div class="main-content-inner">
            <!-- main-content-wrap -->
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Add Product</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href={{ route('admin.dashboard') }}>
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <a href={{ route('admin.products') }}>
                                <div class="text-tiny">Products</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">Edit product</div>
                        </li>
                    </ul>
                </div>
                <!-- form-add-product -->
                <form class="tf-section-2 form-add-product" action="{{ route('admin.product.update', $product->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="wg-box">
                        <!-- Product Name -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter product name" name="name"
                                tabindex="0" value="{{ $product->name }}">
                            <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                        </fieldset>
                        @error('name')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <!-- Slug -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter product slug" name="slug"
                                tabindex="0" value="{{ $product->slug }}">
                            <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                        </fieldset>
                        @error('slug')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <!-- Category & Brand -->
                        <div class="gap22 cols">
                            <fieldset class="category">
                                <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                                <div class="select">
                                    <select name="category_id">
                                        <option>Choose Category</option>
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"{{ $product->category->id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            @error('category_id')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror

                            <fieldset class="brand">
                                <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                                <div class="select">
                                    <select name="brand_id">
                                        <option>Choose Brand</option>
                                        @foreach ($brands as $brand)
                                            <option
                                                value="{{ $brand->id }}"{{ $product->brand->id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            @error('brand_id')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Short Description -->
                        <fieldset class="shortdescription">
                            <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                            <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0">{{ $product->short_description }}</textarea>
                        </fieldset>
                        @error('short_description')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <!-- Description -->
                        <fieldset class="description">
                            <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                            <textarea class="mb-10" name="description" placeholder="Description" tabindex="0">{{ $product->description }}</textarea>
                        </fieldset>
                        @error('description')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="wg-box">
                        <!-- Image Upload -->
                        <fieldset>
                            <div class="body-title">Upload Product Image <span class="tf-color-1">*</span></div>
                            <div class="upload-image flex-grow">
                                @if ($product->image)
                                    <div class="item" id="imgpreview">
                                        <img src="{{ asset('uploads/product/' . $product->image) }}" class="effect8"
                                            alt="preview">
                                    </div>
                                @endif
                                <div id="upload-file" class="item up-load">
                                    <label class="uploadfile" for="myFile">
                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                        <span class="body-text">Drop your images here or select <span class="tf-color">click
                                                to browse</span></span>
                                        <input type="file" id="myFile" name="image" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        @error('image')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <!-- Gallery Upload -->
                        <fieldset>
                            <div class="body-title mb-10">Upload Gallery Images</div>
                            <div class="upload-image mb-16">
                                @if (!empty($product->images))
                                    @foreach (explode(',', $product->images) as $gallery)
                                        @if ($gallery != '')
                                            <div class="item gallerypreview" style="width: 100px; height: 100px; overflow: hidden; border: 1px solid #ccc;">
                                                   <img src="{{ asset('uploads/product/' . $gallery) }}" alt="gallery image"
                                                        style="width: 100%; height: 100%; object-fit: contain;">
                                            </div>

                                        @endif
                                    @endforeach
                                @endif
                                <div id="galUpload" class="item up-load">
                                    <label class="uploadfile" for="gFile">
                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                        <span class="text-tiny">Drop your images here or <span class="tf-color">click to
                                                browse</span></span>
                                        <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        @error('images')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <!-- Prices -->
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Enter regular price"
                                    name="regular_price" tabindex="0" value="{{ $product->regular_price }}">
                            </fieldset>
                            @error('regular_price')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror

                            <fieldset class="name">
                                <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price"
                                    tabindex="0" value="{{ $product->sale_price }}">
                            </fieldset>
                            @error('sale_price')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- SKU / Quantity -->
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU"
                                    tabindex="0" value="{{ $product->SKU }}">
                            </fieldset>
                            @error('SKU')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror

                            <fieldset class="name">
                                <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                    tabindex="0" value="{{ $product->quantity }}">
                            </fieldset>
                            @error('quantity')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Stock / Featured -->
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Stock</div>
                                <div class="select mb-10">
                                    <select name="stock_status">
                                        <option
                                            value="instock"{{ $product->stock_status == 'instock' ? 'selected' : '' }}>
                                            InStock</option>
                                        <option
                                            value="outofstock"{{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>
                                            Out of Stock</option>
                                    </select>
                                </div>
                            </fieldset>
                            @error('stock_status')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror

                            <fieldset class="name">
                                <div class="body-title mb-10">Featured</div>
                                <div class="select mb-10">
                                    <select name="featured">
                                        <option value="0"{{ $product->featured == '0' ? 'selected' : '' }}>No
                                        </option>
                                        <option value="1"{{ $product->featured == '1' ? 'selected' : '' }}>Yes
                                        </option>
                                    </select>
                                </div>
                            </fieldset>
                            @error('featured')
                                <span class="alert alert-danger text-center">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="cols gap10">
                            <button class="tf-button w-full" type="submit">Update product</button>
                        </div>
                    </div>
                </form>

                <!-- /form-add-product -->
            </div>
            <!-- /main-content-wrap -->
        </div>
        <!-- /main-content-wrap -->

        <div class="bottom-page">
            <div class="body-text">Copyright © 2024 SurfsideMedia</div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function() {

                // ✅ Preview single image
                $("#myFile").on("change", function() {
                    const [file] = this.files;
                    if (file) {
                        $("#imgpreview img").attr('src', URL.createObjectURL(file));
                        $("#imgpreview").show();
                    }
                });

                // ✅ Preview gallery images (clear previous ones)
                $("#gFile").on("change", function() {
                    const gphotos = this.files;

                    // ❗ Remove all previous previews inside gallerypreview
                    $(".gallerypreview").remove();

                    // ❗ Also remove previously added JS previews
                    $(".gitems").remove();

                    // ✅ Show new previews
                    $.each(gphotos, function(key, val) {
                        $("#galUpload").before(`
                     <div class="items gitems gallerypreview">
                        <img src="${URL.createObjectURL(val)}" style="width: 100px; height: 100px; object-fit: cover;" />
                    </div>
                `);
                    });
                });


                // ✅ Auto-generate slug from name
                $("input[name='name']").on("change", function() {
                    $("input[name='slug']").val(StringToSlug($(this).val()));
                });

                // ✅ Slug helper
                function StringToSlug(Text) {
                    return Text.toLowerCase()
                        .replace(/[^\w ]+/g, "")
                        .replace(/ +/g, "-");
                }

            });
        </script>
    @endpush
@endsection
