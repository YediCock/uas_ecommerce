// component + n -
// Mendapatkan elemen input dan tombol
// const quantityInput = document.getElementById('myquantity');
// const plusBtn = document.querySelector('.plusBtn');
// const minusBtn = document.querySelector('.minusBtn');

// // Fungsi untuk memperbarui nilai input
// function updateQuantity(increase) {
//     let currentValue = parseInt(quantityInput.value);
    
//     if (increase) {
//         quantityInput.value = currentValue + 1; // Tambah nilai
//     } else {
//         if (currentValue > 1) {
//             quantityInput.value = currentValue - 1; // Kurangi nilai, pastikan tidak kurang dari 1
//         }
//     }
// }

// // Event listener untuk tombol +
// plusBtn.addEventListener('click', () => {
//     updateQuantity(true);
// });

// // Event listener untuk tombol -
// minusBtn.addEventListener('click', () => {
//     updateQuantity(false);
// });
// Ambil semua elemen input dan tombol
// Ambil semua elemen input dan tombol
const quantityInputs = document.querySelectorAll('.myquantity');
const plusBtns = document.querySelectorAll('.plusBtn');
const minusBtns = document.querySelectorAll('.minusBtn');

// Fungsi untuk memperbarui nilai input
function updateQuantity(input, increase) {
    let currentValue = parseInt(input.value);
    
    if (increase) {
        input.value = currentValue + 1; // Tambah nilai
    } else {
        if (currentValue > 1) {
            input.value = currentValue - 1; // Kurangi nilai, pastikan tidak kurang dari 1
        }
    }
}

// Loop melalui setiap tombol plus dan minus untuk menambahkan event listener
plusBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        updateQuantity(quantityInputs[index], true); // Update nilai untuk input terkait
    });
});

minusBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        updateQuantity(quantityInputs[index], false); // Update nilai untuk input terkait
    });
});


// ========== modal 
// document.addEventListener('DOMContentLoaded', function () {
//     var cartOffcanvas = document.getElementById('mycart');

//     // Event listener untuk offcanvas ketika ditampilkan
//     cartOffcanvas.addEventListener('shown.bs.offcanvas', function () {
//         // Set backdrop style
//         var backdrop = document.querySelector('.offcanvas-backdrop');
//         if (backdrop) {
//             backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
//         }
//     });

//     // Event listener untuk offcanvas ketika disembunyikan
//     cartOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
//         // Pastikan backdrop tetap terlihat
//         var backdrop = document.querySelector('.offcanvas-backdrop');
//         if (backdrop) {
//             backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
//         }
//     });
// });
