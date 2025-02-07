@extends('layout.user.app')
@section('title', 'Keranjang')
@section('content')
    <div class="containerkj">
        <a href="{{ route('beranda') }}" class="back-button"><i class="bx bx-left-arrow-alt"></i> Kembali belanja</a>
        <form action="{{ route('checkoutproses') }}" method="POST">
            @csrf
            <div class="cart-section">
                <div class="cart-items">
                    <h1>Keranjang Belanja</h1>
                    @foreach ($data['keranjang'] as $item)
                        <div class="cart-item">
                            <!-- Checkbox tunggal -->
                            <input type="checkbox" name="selected_items[{{ $item->id_barang }}][checked]" value="1">

                            <!-- Input hidden untuk id_barang -->
                            <input type="hidden" name="selected_items[{{ $item->id_barang }}][id_barang]"
                                value="{{ $item->id_barang }}">
                            <input type="hidden" name="selected_items[{{ $item->id_barang }}][id_keranjang]"
                                value="{{ $item->id_keranjang }}">

                            <!-- Gambar barang -->
                            <img src="{{ 'img/barang_img/' . $item->foto_barang }}" alt="{{ $item->nama_barang }}">

                            <div class="item-details">
                                <div class="item-text">
                                    <h2>{{ Str::limit($item->nama_barang, 15) }}</h2>
                                    <p>{{ $item->kategori }}</p>
                                </div>
                                <div class="isiconten">
                                    <div class="quantity-container">
                                        <div class="quantity">
                                            <!-- Input jumlah barang -->
                                            <input type="number" name="selected_items[{{ $item->id_barang }}][jumlah]"
                                                min="1" max="{{ $item->stok_barang }}"
                                                value="{{ $item->total_barang_satuan }}">
                                            <div class="quantity-nav" >
                                                <div class="quantity-button quantity-up" data-id="{{ $item->id_barang }}">+</div>
                                                <div class="quantity-button quantity-down">−</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item-pricing">
                                        <span>Rp
                                            {{ number_format($item->total_barang_satuan * $item->harga_barang, 0, ',', '.') }}</span>
                                        <small>Rp {{ number_format($item->harga_barang, 0, ',', '.') }} / per item</small>
                                    </div>
                                    <button type="button" class="delete" data-id="{{ $item->id_barang }}"><i
                                            class="bx bxs-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="cart-summary">
                    <div class="summary">
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Total Harga</td>
                                    <td>:</td>
                                    <td id="total-harga">Rp.0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="checkout">CHECK OUT</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('linkjs')
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('css/user/js/home.js') }}"></script>
    <script>
        const recommendation = document.querySelector('.recommendation');
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');

        let currentPosition = 0;
        let isDragging = false;
        let startX = 0;
        let scrollLeft = 0;

        // Event untuk tombol Next
        nextBtn.addEventListener('click', () => {
            const maxScroll = recommendation.scrollWidth - recommendation.clientWidth;
            if (currentPosition < maxScroll) {
                currentPosition += 290; // Geser ke kanan 1 card
                recommendation.style.transform = `translateX(-${currentPosition}px)`;
                recommendation.style.transition = 'transform 0.3s ease';
            }
        });

        // Event untuk tombol Prev
        prevBtn.addEventListener('click', () => {
            if (currentPosition > 0) {
                currentPosition -= 290; // Geser ke kiri 1 card
                recommendation.style.transform = `translateX(-${currentPosition}px)`;
                recommendation.style.transition = 'transform 0.3s ease';
            }
        });

        // Event saat mouse ditekan
        recommendation.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - recommendation.offsetLeft;
            scrollLeft = recommendation.scrollLeft;
            recommendation.style.cursor = 'grabbing';
        });

        // Event saat mouse dilepaskan
        recommendation.addEventListener('mouseup', () => {
            isDragging = false;
            recommendation.style.cursor = 'grab';
        });

        // Event saat mouse keluar area slider
        recommendation.addEventListener('mouseleave', () => {
            isDragging = false;
            recommendation.style.cursor = 'grab';
        });

        // Event saat mouse digerakkan
        recommendation.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - recommendation.offsetLeft;
            const walk = x - startX; // Jarak gerakan mouse
            recommendation.scrollLeft = scrollLeft - walk; // Geser konten slider
        });

        // Dukungan untuk perangkat sentuh (mobile)
        recommendation.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].pageX - recommendation.offsetLeft;
            scrollLeft = recommendation.scrollLeft;
        });

        recommendation.addEventListener('touchend', () => {
            isDragging = false;
        });

        recommendation.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX - recommendation.offsetLeft;
            const walk = x - startX;
            recommendation.scrollLeft = scrollLeft - walk;
        });
    </script>
    <script>
        document.querySelectorAll('.quantity-button').forEach(button => {
    button.addEventListener('click', function() {
        const quantityContainer = this.closest('.quantity-container');
        const input = quantityContainer.querySelector('input[type="number"]');
        const itemPricing = quantityContainer.closest('.isiconten').querySelector('.item-pricing span');
        const pricePerItem = parseInt(
            quantityContainer.closest('.isiconten').querySelector('.item-pricing small')
            .innerText
            .replace('Rp', '').replace('.', '').replace(',', '').trim(),
            10
        );

        const currentValue = parseInt(input.value, 10);
        const isIncrement = this.classList.contains('quantity-up');
        const newValue = isIncrement ? currentValue + 1 : currentValue - 1;

        // Set nilai baru, pastikan tetap dalam batas min dan max
        if (newValue >= input.min && newValue <= input.max) {
            input.value = newValue;

            // Perbarui total harga
            const newTotal = newValue * pricePerItem;
            itemPricing.innerText = `Rp ${newTotal.toLocaleString('id-ID')}`;

            // Extract itemId from the input name attribute
            const itemIdMatch = input.name.match(/\[([0-9]+)\]/); // Match the item ID in the name attribute
            const itemId = itemIdMatch ? itemIdMatch[1] : null;

            if (itemId) {
                updateDatabase(itemId, newValue); // Kirim itemId yang valid
            } else {
                console.error('itemId tidak ditemukan');
            }
        }
    });
});

function updateDatabase(itemId, quantity) {
    console.log('Mengirim data ke server:', {
        itemId,
        quantity
    }); // Debug: Log data yang dikirim

    fetch('/keranjang/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                itemId,
                quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Keranjang berhasil diperbarui');
                updateTotalHarga(); // Panggil fungsi untuk memperbarui total keseluruhan
            } else {
                console.error('Gagal memperbarui keranjang:', data.message);
            }
        })
        .catch(error => console.error('Terjadi kesalahan:', error));
}



        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                const cartItem = this.closest('.cart-item');

                // Tampilkan konfirmasi menggunakan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Item ini akan dihapus dari keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna menekan "Ya, hapus!"
                        fetch(`/keranjang/hapus/${itemId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute(
                                        'content')
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    cartItem.remove();
                                    Swal.fire(
                                        'Dihapus!',
                                        'Item berhasil dihapus dari keranjang.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Dihapus!',
                                        'Item berhasil dihapus dari keranjang.',
                                        'success'
                                    ).then(() => {
                                        // Refresh halaman setelah SweetAlert ditutup
                                        location.reload();
                                    });;
                                }
                            });
                    }
                });
            });
        });
        // Seleksi semua checkbox dan elemen total harga
        const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]');
        const totalHargaElement = document.getElementById('total-harga');

        // Fungsi untuk menghitung total harga
        function updateTotalHarga() {
            let totalHarga = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const cartItem = checkbox.closest('.cart-item');
                    const priceElement = cartItem.querySelector('.item-pricing span');
                    const price = parseInt(
                        priceElement.textContent.replace('Rp', '').replace(/\./g, '').trim()
                    );
                    totalHarga += price;
                }
            });

            // Update elemen total harga
            totalHargaElement.textContent = `Rp.${totalHarga.toLocaleString('id-ID')}`;
        }

        // Tambahkan event listener ke setiap checkbox
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalHarga);
        });

        // Hitung total harga saat halaman pertama kali dimuat
        updateTotalHarga();
    </script>
@endsection
@section('linkcss')
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&family=Righteous&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Kavoon&family=Righteous&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('css/user/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/keranjang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/css/footer.css') }}">
    <style>
        .top-bar.scrolled {
            background-color: #ffe8df;
        }

        .item-text h2 {
            display: inline-block;
            width: 160px;
            /* Atur panjang yang sesuai */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
