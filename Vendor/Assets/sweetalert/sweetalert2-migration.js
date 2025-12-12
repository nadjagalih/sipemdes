/*
 * SweetAlert2 Migration Guide
 * File ini berisi informasi migrasi dari SweetAlert lama ke SweetAlert2
 */

// MIGRASI SINTAKS:
// Lama: swal("Title", "Message", "type");
// Baru: Swal.fire("Title", "Message", "type");

// Lama: swal({title: "Title", text: "Message", icon: "warning"});
// Baru: Swal.fire({title: "Title", text: "Message", icon: "warning"});

// CONTOH PENGGUNAAN BARU:
// Success alert:
// Swal.fire('Success!', 'Data berhasil disimpan!', 'success');

// Error alert:
// Swal.fire('Error!', 'Terjadi kesalahan!', 'error');

// Confirmation:
// Swal.fire({
//   title: 'Apakah Anda yakin?',
//   text: "Data ini akan dihapus!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Ya, hapus!',
//   cancelButtonText: 'Batal'
// }).then((result) => {
//   if (result.isConfirmed) {
//     // Action ketika dikonfirmasi
//   }
// });