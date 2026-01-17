<x-layouts.admin title="Detail Event">
    <div class="container mx-auto p-10">
        @if (session('success'))
            <div class="toast toast-bottom toast-center z-50">
                <div class="alert alert-success">
                    <span>{{ session('success') }}</span>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    document.querySelector('.toast')?.remove()
                }, 3000)
            </script>
        @endif
        <div class="card bg-base-100 shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-6">Detail Event</h2>

                <form id="eventForm" class="space-y-4" method="post"
                    action="{{ route('admin.events.update', $event->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Nama Event -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Judul Event</span>
                        </label>
                        <input type="text" name="title" placeholder="Contoh: Konser Musik Rock"
                            class="input input-bordered w-full" value="{{ $event->title }}" disabled required />
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Deskripsi</span>
                        </label>
                        <br>
                        <textarea name="description" placeholder="Deskripsi lengkap tentang event..."
                            class="textarea textarea-bordered h-24 w-full" disabled required>{{ $event->description }}</textarea>
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tanggal & Waktu</span>
                        </label>
                        <input type="datetime-local" name="date_time" class="input input-bordered w-full"
                            value="{{ $event->date_time->format('Y-m-d\TH:i') }}" disabled required />
                    </div>

                    <!-- Lokasi -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Lokasi</span>
                        </label>
                        <input type="text" name="location" placeholder="Contoh: Stadion Utama"
                            class="input input-bordered w-full" value="{{ $event->location }}" disabled required />
                    </div>

                    <!-- Kategori -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Kategori</span>
                        </label>
                        <select name="category_id" class="select select-bordered w-full" required disabled>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $event->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Gambar Event</span>
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="file-input file-input-bordered w-full" disabled />
                        <label class="label">
                            <span class="label-text-alt">Format: JPG, PNG, max 5MB</span>
                        </label>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="imagePreview" class="overflow-hidden {{ $event->image ? '' : 'hidden' }}">
                        <label class="label">
                            <span class="label-text font-semibold">Preview Gambar</span>
                        </label>
                        <br>
                        <div class="avatar max-w-sm">
                            <div class="w-full rounded-lg">
                                @if ($event->image)
                                    <img id="previewImg" src="{{ asset('images/events/' . $event->image) }}"
                                        alt="Preview">
                                @else
                                    <img id="previewImg" src="" alt="Preview">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Mobilitas -->
                    <div class="card-actions justify-end mt-6">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Kembali</a>
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-white btn bg-blue-500">Edit</a>
                        <button type="button" onclick="openDeleteModal(this)" data-id="{{ $event->id }}" class="text-white btn bg-red-500">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <dialog id="delete_modal" class="modal">
        <form method="POST" class="modal-box">
            @csrf
            @method('DELETE')

            <input type="hidden" name="event_id" id="delete_event_id">

            <h3 class="text-lg font-bold mb-4">Hapus Event</h3>
            <p>Apakah Anda yakin ingin menghapus event ini?</p>
            <div class="modal-action">
                <button class="btn btn-primary" type="submit">Hapus</button>
                <button class="btn" onclick="delete_modal.close()" type="reset">Batal</button>
            </div>
        </form>
    </dialog>

    <script>
        function openDeleteModal(button) {
            const id = button.dataset.id;
            const form = document.querySelector('#delete_modal form');
            document.getElementById("delete_event_id").value = id;

            // Set action dengan parameter ID
            form.action = `/admin/events/${id}`

            delete_modal.showModal();
        }
    </script>

    <script>
        const form = document.getElementById('eventForm');
        const fileInput = form.querySelector('input[type="file"]');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const successAlert = document.getElementById('successAlert');

        // Preview gambar saat dipilih
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

    </script>
</x-layouts.admin>
