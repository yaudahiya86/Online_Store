//================= edit profil =====================================

document.addEventListener("DOMContentLoaded", function () {
    const editProfileButton = document.querySelector(".edit-profile");
    const profileDetails = document.querySelector(".profile-details");

    editProfileButton.addEventListener("click", function () {
        // Toggle edit mode
        const isEditing = profileDetails.classList.toggle("editing");
        if (isEditing) {
            // Change button style and text
            editProfileButton.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
            editProfileButton.classList.add("active");

            // Replace profile details with editable inputs
            const profileInfo = profileDetails.querySelector(".profile-info");
            profileInfo.innerHTML = `
                <p><strong>Nama Lengkap:</strong> <input type="text" value="Dimas Avenger" class="edit-input"></p>
                <p><strong>Email:</strong> <input type="email" value="kembang@gmail.com" class="edit-input"></p>
                <p><strong>Phone:</strong> <input type="text" value="+62 123 456 789" class="edit-input"></p>
                <p><strong>Alamat:</strong> <input type="text" value="Jl Simpony, Wlingi, Blitar Jawa Timur" class="edit-input"></p>
            `;
        } else {
            // Change button back to Edit Profile
            editProfileButton.innerHTML = '<i class="fas fa-user-edit"></i> Edit Profile';
            editProfileButton.classList.remove("active");

            // Simpan data dan kembali ke tampilan biasa
            const inputs = profileDetails.querySelectorAll(".edit-input");
            const updatedData = Array.from(inputs).map(input => input.value);

            profileDetails.querySelector(".profile-info").innerHTML = `
                <p><strong>Nama Lengkap:</strong> <span>${updatedData[0]}</span></p>
                <p><strong>Email:</strong> <span>${updatedData[1]}</span></p>
                <p><strong>Phone:</strong> <span>${updatedData[2]}</span></p>
                <p><strong>Alamat:</strong> <span>${updatedData[3]}</span></p>
            `;
        }
    });
});


// ------------ ganti PP -----------------------

document.addEventListener("DOMContentLoaded", function () {
    const editPhotoIcon = document.getElementById("editPhotoIcon");
    const uploadPhoto = document.getElementById("uploadPhoto");
    const profilePicture = document.getElementById("profilePicture");

    // Trigger file input when icon is clicked
    editPhotoIcon.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        uploadPhoto.click();
    });

    // Update profile picture when a new file is selected
    uploadPhoto.addEventListener("change", function () {
        const file = uploadPhoto.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                profilePicture.src = e.target.result; // Update image source
            };

            reader.readAsDataURL(file); // Read the file as a data URL
        }
    });
});