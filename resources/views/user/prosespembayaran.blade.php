@extends('layout.user.app')
@section('title', 'Proses Pembayaran')
@section('content')
    <div class="containerkj">
        <center>
            <h1>Anda harus Melakukan Pembayaran Sebesar Rp {{ number_format($total_harga_semua, 0, ',', '.') }}</h1>
        </center>
        <small>Jika pop up pembayaran tidak muncul silahkan <span id="pay-button">klik disini</span></small>
    </div>

@endsection
@section('linkjs')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
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
                const itemPricing = quantityContainer.closest('.isiconten').querySelector(
                    '.item-pricing span');
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
                    const itemIdMatch = input.name.match(
                        /\[([0-9]+)\]/); // Match the item ID in the name attribute
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
    <script>
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href = '{{ route('pembayaranberhasil', ['id_pesanan' => $id_pesanan]) }}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
        // Tambahkan event listener saat halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    window.location.href = '{{ route('pembayaranberhasil', ['id_pesanan' => $id_pesanan]) }}';
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        });
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

        #pay-button {
            color: blue;
            text-decoration: underline;
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
