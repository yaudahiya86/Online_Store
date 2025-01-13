@extends('layout.user.app')
@section('title', 'Profil')
@section('linkcss')
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/profil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
@section('content')
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture-wrapper">
                <img src="{{ asset('img/profiluser/' . $data['profil']->foto) }}" alt="User Photo" class="profile-picture"
                    id="profilePicture">
                <a href="#" id="editPhotoIcon"><i class="fas fa-camera edit-photo-icon"></i></a>
                <input type="file" id="uploadPhoto" accept="image/*" style="display: none;">
            </div>
            <h1 class="username">{{ $data['profil']->nama_lengkap }}</h1>
            <p class="email"><i class="fas fa-envelope"></i> {{ $data['profil']->email }}</p>
            <button class="edit-profile" id="editProfileBtn"><i class="fas fa-user-edit"></i> Edit Profile</button>
            <a href="{{route('histori')}}"><button class="edit-profile"><i class="fas fa-history"></i> History</button></a>
        </div>
        <div class="profile-details card-prf">
            <h2><i class="fas fa-info-circle"></i> Profile Information</h2>
            <div class="profile-info">
                <p><strong>Nama Lengkap:</strong> <span id="namaLengkap">{{ $data['profil']->nama_lengkap }}</span></p>
                <p><strong>Email:</strong> <span id="email">{{ $data['profil']->email }}</span></p>
                <p><strong>Phone:</strong> <span id="phone">{{ $data['profil']->telephone }}</span></p>
                <p><strong>Alamat:</strong> <span id="alamat">{{ $data['profil']->alamat }}</span></p>
            </div>
            {{-- <button class="edit-profile" id="editProfileBtn"><i class="fas fa-user-edit"></i> Edit Profile</button> --}}
            <button class="edit-profile" id="saveProfileBtn" style="display: none;"><i class="fas fa-save"></i>
                Save</button>

        </div>
        {{-- <div class="order-history card-prf">
        <h2><i class="fas fa-shopping-cart"></i> Order History</h2>
        <ul class="orders">
            <a href=""><li>Order 1 - Melati</li></a>
            <li>Order 2 - Matahari</li>
            <li>Order 3 - Matahari</li>
        </ul>
    </div> --}}
    </div>
@endsection
@section('linkjs')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
    <script src="{{ asset('css/user/js/profil.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editPhotoIcon = document.getElementById("editPhotoIcon");
            const uploadPhoto = document.getElementById("uploadPhoto");
            const profilePicture = document.getElementById("profilePicture");

            // Trigger file input when icon is clicked
            editPhotoIcon.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                uploadPhoto.click();
            });

            // Update profile picture and send to server
            uploadPhoto.addEventListener("change", function() {
                const file = uploadPhoto.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        profilePicture.src = e.target.result; // Update image source in the UI
                    };

                    reader.readAsDataURL(file); // Read the file as a data URL

                    // Send the file to the server
                    const formData = new FormData();
                    formData.append("foto", file);

                    fetch("/profil/gantipp", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content") // For Laravel CSRF protection
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Failed to upload photo");
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Foto profil berhasil diperbarui',
                                background: '#f0f9ff', // Biru muda pastel
                                iconColor: '#38bdf8', // Biru cerah untuk ikon
                                color: '#1e3a8a', // Teks biru tua
                                backdrop: 'rgba(0, 0, 0, 0.2)', // Latar belakang gelap dengan transparansi 20%
                                showConfirmButton: false,
                                timer: 1500
                            });
                            profilePicture.src = '/img/profiluser/' + data
                            .foto; // Update the image with the new one
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Gagal memperbarui foto profil.");
                        });
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('editProfileBtn');
            const saveBtn = document.getElementById('saveProfileBtn');
            const fields = ['namaLengkap', 'email', 'phone', 'alamat'];

            editBtn.addEventListener('click', function() {
                fields.forEach(id => {
                    const span = document.getElementById(id);
                    const value = span.textContent;
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = value;
                    input.id = id; // Replace existing span ID with input ID
                    input.className = 'form-control edit-input';
                    span.replaceWith(input);
                });

                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';
            });

            saveBtn.addEventListener('click', function() {
                fields.forEach(id => {
                    const input = document.getElementById(id);
                    const value = input.value;
                    const span = document.createElement('span');
                    span.id = id; // Replace input ID with span ID
                    span.textContent = value;
                    input.replaceWith(span);
                });

                saveBtn.style.display = 'none';
                editBtn.style.display = 'inline-block';

                // Lakukan AJAX request untuk menyimpan data di backend
                const data = {
                    namaLengkap: document.getElementById('namaLengkap').textContent,
                    email: document.getElementById('email').textContent,
                    phone: document.getElementById('phone').textContent,
                    alamat: document.getElementById('alamat').textContent
                };

                fetch('/profil/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    }).then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire('Berhasil', 'Profil berhasil diperbarui!', 'success');
                        } else {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan!', 'error');
                        }
                    });
            });
        });
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                background: '#f0f9ff', // Biru muda pastel
                iconColor: '#38bdf8', // Biru cerah untuk ikon
                color: '#1e3a8a', // Teks biru tua
                backdrop: 'rgba(0, 0, 0, 0.2)', // Latar belakang gelap dengan transparansi 20%
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endsection
