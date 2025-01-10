//================= edit profil =====================================

// document.addEventListener("DOMContentLoaded", function () {
//     const editProfileButton = document.querySelector(".edit-profile");
//     const profileDetails = document.querySelector(".profile-details");

//     editProfileButton.addEventListener("click", function () {
//         // Toggle edit mode
//         const isEditing = profileDetails.classList.toggle("editing");
//         if (isEditing) {
//             // Change button style and text
//             editProfileButton.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
//             editProfileButton.classList.add("active");

//             // Replace profile details with editable inputs
//             const profileInfo = profileDetails.querySelector(".profile-info");
//             profileInfo.innerHTML = `
//                 <p><strong>Nama Lengkap:</strong> <input type="text" value="Dimas Avenger" class="edit-input" name="nama_lengkap"></p>
//                 <p><strong>Email:</strong> <input type="email" value="kembang@gmail.com" class="edit-input" name="email"></p>
//                 <p><strong>Phone:</strong> <input type="text" value="+62 123 456 789" class="edit-input" name="telephone"></p>
//                 <p><strong>Alamat:</strong> <input type="text" value="Jl Simpony, Wlingi, Blitar Jawa Timur" class="edit-input" name="alamat"></p>
//             `;
//         } else {
//             // Change button back to Edit Profile
//             editProfileButton.innerHTML = '<i class="fas fa-user-edit"></i> Edit Profile';
//             editProfileButton.classList.remove("active");

//             // Simpan data dan kirim ke server
//             const inputs = profileDetails.querySelectorAll(".edit-input");
//             const updatedData = {};
//             inputs.forEach(input => {
//                 updatedData[input.name] = input.value;
//             });

//             // Kirim data ke server menggunakan fetch
//             fetch("/profil/update", {
//                 method: "POST",
//                 headers: {
//                     "Content-Type": "application/json",
//                 },
//                 body: JSON.stringify(updatedData),
//             })
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error("Gagal menyimpan data.");
//                 }
//                 return response.json();
//             })
//             .then(data => {
//                 // Perbarui tampilan dengan data terbaru jika berhasil
//                 profileDetails.querySelector(".profile-info").innerHTML = `
//                     <p><strong>Nama Lengkap:</strong> <span>${updatedData.nama_lengkap}</span></p>
//                     <p><strong>Email:</strong> <span>${updatedData.email}</span></p>
//                     <p><strong>Phone:</strong> <span>${updatedData.telephone}</span></p>
//                     <p><strong>Alamat:</strong> <span>${updatedData.alamat}</span></p>
//                 `;
//                 alert("Profil berhasil diperbarui!");
//             })
//             .catch(error => {
//                 alert("Terjadi kesalahan: " + error.message);
//             });
//         }
//     });
// });



// ------------ ganti PP -----------------------

// document.addEventListener("DOMContentLoaded", function () {
//     const editPhotoIcon = document.getElementById("editPhotoIcon");
//     const uploadPhoto = document.getElementById("uploadPhoto");
//     const profilePicture = document.getElementById("profilePicture");

//     // Trigger file input when icon is clicked
//     editPhotoIcon.addEventListener("click", function (e) {
//         e.preventDefault(); // Prevent default anchor behavior
//         uploadPhoto.click();
//     });

//     // Update profile picture when a new file is selected
//     uploadPhoto.addEventListener("change", function () {
//         const file = uploadPhoto.files[0];
//         if (file) {
//             const reader = new FileReader();

//             reader.onload = function (e) {
//                 profilePicture.src = e.target.result; // Update image source
//             };

//             reader.readAsDataURL(file); // Read the file as a data URL
//         }
//     });
// });