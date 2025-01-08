

// dark mode
const body = document.querySelector("body"),
      nav = document.querySelector("nav"),
      modeToggle = document.querySelector(".dark-light"),
      searchToggle = document.querySelector(".searchToggle"),
      sidebarOpen = document.querySelector(".sidebarOpen"),
      siderbarClose = document.querySelector(".siderbarClose");

      let getMode = localStorage.getItem("mode");
          if(getMode && getMode === "dark-mode"){
            body.classList.add("dark");
          }

      modeToggle.addEventListener("click" , () =>{
        modeToggle.classList.toggle("active");
        body.classList.toggle("dark");

        if(!body.classList.contains("dark")){
            localStorage.setItem("mode" , "light-mode");
        }else{
            localStorage.setItem("mode" , "dark-mode");
        }
      });

        searchToggle.addEventListener("click" , () =>{
        searchToggle.classList.toggle("active");
      });
 
sidebarOpen.addEventListener("click" , () =>{
    nav.classList.add("active");
});

body.addEventListener("click" , e =>{
    let clickedElm = e.target;

    if(!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")){
        nav.classList.remove("active");
    }
});




window.addEventListener('scroll', function() {
  const navbar = document.querySelector('nav'); // Menargetkan navbar
  const topBar = document.querySelector('.top-bar'); // Menargetkan top bar
  
  // Mengubah warna navbar saat di-scroll
  if (window.scrollY > 10) {  
      navbar.classList.add('scrolled');
      topBar.classList.add('scrolled');  // Menambahkan kelas untuk top bar
  } else {
      navbar.classList.remove('scrolled');
      topBar.classList.remove('scrolled');  // Menghapus kelas untuk top bar
  }
});



function f() {
  document.getElementsByClassName("dropdown")[0].classList.toggle("down");
  document.getElementsByClassName("arrow")[0].classList.toggle("gone");
  if (
    document.getElementsByClassName("dropdown")[0].classList.contains("down")
  ) {
    setTimeout(function () {
      document.getElementsByClassName("dropdown")[0].style.overflow = "visible";
    }, 500);
  } else {
    document.getElementsByClassName("dropdown")[0].style.overflow = "hidden";
  }
}

var swiper = new Swiper('.blog-slider', {
  spaceBetween: 30,
  effect: 'fade',
  loop: true,
  mousewheel: {
    invert: false,
  },
  // autoHeight: true,
  pagination: {
    el: '.blog-slider__pagination',
    clickable: true,
  }
});


// show moreee
document.getElementById('showMoreBtn').addEventListener('click', function () {
  const moreProducts = document.getElementById('moreProducts');
  const btn = document.getElementById('showMoreBtn');

  if (moreProducts.style.display === 'none' || moreProducts.style.display === '') {
    moreProducts.style.display = 'grid';
    btn.textContent = 'Tampilkan Lebih Sedikit'; 
  } else {
    moreProducts.style.display = 'none';
    btn.textContent = 'Lihat Lainya'; 
  }
});



// kategori
// Tangkap elemen dropdown dan container
const dropdownItems = document.querySelectorAll('.dropdown p');
const productContainer = document.getElementById('productContainer');
const productContainer2 = document.getElementById('productContainer2');
const newContent = document.getElementById('newContent');
const newContent2 = document.getElementById('newContent2');
const dynamicContents = document.querySelectorAll('.dynamic-content');

// Tambahkan event listener ke setiap elemen dropdown
dropdownItems.forEach(item => {
  item.addEventListener('click', () => {
    // Ambil nilai data-content dari elemen yang diklik
    const contentType = item.getAttribute('data-content');

    if (contentType === '') {
      // Jika "Utama" diklik, tampilkan konten awal
      productContainer.style.display = 'grid';
      newContent.style.display = 'none';
    } else {
      // Jika opsi lain diklik, sembunyikan konten 
      productContainer.style.display = 'none';
      newContent.style.display = 'block';
      // Sembunyikan semua konten dinamis
      dynamicContents.forEach(content => content.style.display = 'none');

      // Tampilkan konten yang sesuai dengan data-content
      const targetContent = document.getElementById(`${contentType}Content`);
      if (targetContent) {
        targetContent.style.display = 'block';
      }
    }
  });

  item.addEventListener('click', () => {
    // Ambil nilai data-content dari elemen yang diklik
    const contentType = item.getAttribute('data-content2');

    if (contentType === '') {
      // Jika "Utama" diklik, tampilkan konten awal
      productContainer2.style.display = 'grid';
      newContent2.style.display = 'none';
    } else {
      // Jika opsi lain diklik, sembunyikan konten awal
      textContent2.style.display = 'block';
      textContent.style.display = 'none';
      productContainer2.style.display = 'none';
      newContent2.style.display = 'block';
      

      // Sembunyikan semua konten dinamis
      dynamicContents.forEach(content => content.style.display = 'none');
      // Tampilkan konten yang sesuai dengan data-content
      const targetContent = document.getElementById(`${contentType}Content`);
      if (targetContent) {
        targetContent.style.display = 'block';
      }
    }
   
  });
});

