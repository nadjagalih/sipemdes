<?php

// Upload gambar untuk Logo Fav Website
function Upload_Fav($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/favicon_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 300) {
    $dst_width = 300;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=============================================================================

// Upload gambar untuk ceo profile
function Upload_Profile_CEO($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/ceo_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 3000) {
    $dst_width = 2000;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  //$dst_width2 = 2000;
  //$dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  //$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  //imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //switch($imageType) {
  //  case "image/gif":
  //  imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/pjpeg":
  //  case "image/jpeg":
  //  case "image/jpg":
  //  imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/PNG":
  //  case "image/png":
  //  case "image/x-png":
  // imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

//==================================================================================================================

// Upload gambar untuk Logo Website
function Upload_Logo($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/logo_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 300) {
    $dst_width = 300;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=====================================================================================================

// Upload gambar untuk Logo Website
function Upload_Sambutan($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/sambutan_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 300) {
    $dst_width = 300;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=====================================================================================================
// UPLOAD FOTO POST
function Upload_Post_Profile($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/post_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=============================================================================

// UPLOAD FOTO ARTIKEL
function Upload_Post_Artikel($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/artikel_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=============================================================================

// UPLOAD FOTO Inovasi
function Upload_Post_Inovasi($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/foto_inovasi/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 2000) {
    $dst_width = 1500;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=============================================================================

// UPLOAD FOTO AGENDA KEGIATAN
function Upload_Post_Agenda($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/agenda_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 200;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=====================================================================================================

// UPLOAD FOTO PENGUMUMAN
function Upload_Post_Pengumuman($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/pengumuman_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=====================================================================================================


// Upload file untuk UPLOAD file=======================================================================
function Upload_File($fupload_name)
{
  //direktori file
  $vdir_upload = "../media/file_dip_upload/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan file
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}
//=====================================================================================================

// Upload Video=======================================================================
function Upload_Video($fupload_name)
{
  //direktori file
  $vdir_upload = "../media/video_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan file
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}


// Upload Album Galery
function Upload_Album($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/album_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 550) {
    $dst_width = 550;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 150;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//===========================================================================================================

// Upload Galery
function Upload_Galeri($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/galeri_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 1000) {
    $dst_width = 1000;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {

    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;

    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;

    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 150;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//==========================================================================================================

// Upload Icon
function Upload_Icon($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../galery/maps/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  // switch($imageType) {

  //   case "image/gif":
  //   $im_src=imagecreatefromgif($vfile_upload);
  //   break;

  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   $im_src=imagecreatefromjpeg($vfile_upload);
  //   break;

  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   $im_src=imagecreatefrompng($vfile_upload);
  //   break;

  // }

  // $src_width = imageSX($im_src);
  // $src_height = imageSY($im_src);

  // //Simpan dalam versi besar 400 pixel
  // //Set ukuran gambar hasil perubahan
  // if($src_width>=1000){
  //   $dst_width = 1000;
  // } else {
  //   $dst_width = $src_width;
  // }
  // $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  // $im = imagecreatetruecolor($dst_width,$dst_height);
  //imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im,$vdir_upload.$fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im,$vdir_upload.$fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im,$vdir_upload.$fupload_name);
  //   break;
  // }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 150;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  // imagedestroy($im_src);
  // imagedestroy($im);
  // imagedestroy($im2);
}
// =========================================================================

// Upload gambar USER
function Upload_Foto_Profile($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/profile_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 550) {
    $dst_width = 550;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 150;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//====================================================================================================================

// Upload gambar untuk Dokumen Komentar
function Upload_Dokumen_Komentar($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/dokumentasi_komentar/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 550) {
    $dst_width = 550;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 150;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//==============================================================================================================


// Upload gambar untuk Logo Website
function Upload_Slide($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../media/slide_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 2000) {
    $dst_width = 1500;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  //$dst_width2 = 2000;
  //$dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  //$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  //imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //switch($imageType) {
  //  case "image/gif":
  //  imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/pjpeg":
  //  case "image/jpeg":
  //  case "image/jpg":
  //  imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/PNG":
  //  case "image/png":
  //  case "image/x-png":
  //  imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //}

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//=======================================================================================================================

// UPLOAD FOTO POST_sambutan
function Upload_Post_Sambutan($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/sambutan_pic/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

//===============================================================================================================

// UPLOAD FOTO post kontak
function Upload_Post_Kontak($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/foto_kontak/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  // $dst_width2 = 200;
  // $dst_height2 = ($dst_width2/$src_width)*$src_height;

  // //proses perubahan ukuran
  // $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  // imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  // //Simpan gambar
  // switch($imageType) {
  //   case "image/gif":
  //   imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/pjpeg":
  //   case "image/jpeg":
  //   case "image/jpg":
  //   imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  //   case "image/PNG":
  //   case "image/png":
  //   case "image/x-png":
  //   imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //   break;
  // }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

//===============================================================================================================

// UPLOAD FOTO post Link
function Upload_Link($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/foto_link/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 1000) {
    $dst_width = 1000;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  //$dst_width2 = 600;
  //$dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  //$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  //imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //switch($imageType) {
  //  case "image/gif":
  //  imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/pjpeg":
  //  case "image/jpeg":
  //  case "image/jpg":
  //  imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/PNG":
  //  case "image/png":
  //  case "image/x-png":
  //  imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //}

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

//===============================================================================================================

// UPLOAD FOTO ALBUM BUNDA PAUD
function Upload_Album_Bunda_Paud($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/foto_album_bunda_paud/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 1000) {
    $dst_width = 1000;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  //$dst_width2 = 600;
  //$dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  //$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  //imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //switch($imageType) {
  //  case "image/gif":
  //  imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/pjpeg":
  //  case "image/jpeg":
  //  case "image/jpg":
  //  imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/PNG":
  //  case "image/png":
  //  case "image/x-png":
  //  imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //}

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}


//===============================================================================================================

// UPLOAD FOTO ALBUM BUNDA PAUD
function Upload_Galery_Bunda_Paud($fupload_name)
{
  //direktori gambar post profile
  $vdir_upload = "../media/foto_galeri_bunda_paud/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 1000) {
    $dst_width = 1000;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/PNG":
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }

  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  //$dst_width2 = 600;
  //$dst_height2 = ($dst_width2/$src_width)*$src_height;

  //proses perubahan ukuran
  //$im2 = imagecreatetruecolor($dst_width2,$dst_height2);
  //imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  //switch($imageType) {
  //  case "image/gif":
  //  imagegif($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/pjpeg":
  //  case "image/jpeg":
  //  case "image/jpg":
  //  imagejpeg($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //  case "image/PNG":
  //  case "image/png":
  //  case "image/x-png":
  //  imagepng($im2,$vdir_upload . "small_" . $fupload_name);
  //  break;
  //}

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
//SAMPAI SINI=====================================================================================================





//BUAT PSANG IKLAN
function Uploadpasangiklan($fupload_name)
{
  //direktori Logo
  $vdir_upload = "../../../foto_pasangiklan/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}



//BUAT IKLAN TENGAH
function Uploadiklantengah($fupload_name)
{
  //direktori Logo
  $vdir_upload = "../../../foto_iklantengah/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}


//BUAT IKLAN ATAS
function Uploadiklanatas($fupload_name)
{
  //direktori Logo
  $vdir_upload = "../../../foto_iklanatas/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}




//BUAT HEADER
function UploadHeader($fupload_name)
{
  //direktori Header
  $vdir_upload = "../../../header/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}

//BUAT LOGO
function UploadLogo($fupload_name)
{
  //direktori Logo
  $vdir_upload = "../../../logo/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}


//BUAT BACKGROUND
function UploadBackground($fupload_name)
{
  //direktori Background
  $vdir_upload = "../../../img_background/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $tipe_file   = $_FILES['fupload']['type'];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}


//BUAT BANNER
function UploadBanner($fupload_name)
{
  //direktori banner
  $vdir_upload = "../../../foto_banner/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}


// Upload gambar untuk album galeri foto
function UploadAlbum($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../img_album/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 200) {
    $dst_width = 200;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 150;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}




// Upload gambar untuk galeri foto
function UploadGallery($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../img_galeri/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 550) {
    $dst_width = 550;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 150;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}





// VIDEO ///////////////////////////////////////////////////////////
function UploadPlaylist($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../img_playlist/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 200) {
    $dst_width = 200;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 150;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}




//BUAT VIDEO
function UploadVideo($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../img_video/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 200;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "kecil_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

///////////////////////////////////////////////
function UploadVideo2($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../img_video/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload2"]["tmp_name"], $vfile_upload);
}

// Upload gambar Halaman Statis
function UploadStatis($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../foto_statis/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi besar 400 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 400) {
    $dst_width = 400;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 200 pixel
  //Set ukuran gambar hasil perubahan

  $dst_width2 = 200;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "small_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}




// BUAT USER //////////////////////////////////////////////////////
function UploadUser($fupload_name)
{
  //direktori gambar
  $vdir_upload = "../../../foto_user/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 196 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 200) {
    $dst_width = 200;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 110;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "small_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}

// BUAT USER //////////////////////////////////////////////////////
function UploadUser2($fupload_name)
{
  //direktori gambar
  $vdir_upload = "foto_user/";
  $vfile_upload = $vdir_upload . $fupload_name;
  $imageType = $_FILES["fupload"]["type"];

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  switch ($imageType) {
    case "image/gif":
      $im_src = imagecreatefromgif($vfile_upload);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      $im_src = imagecreatefromjpeg($vfile_upload);
      break;
    case "image/png":
    case "image/x-png":
      $im_src = imagecreatefrompng($vfile_upload);
      break;
  }

  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 196 pixel
  //Set ukuran gambar hasil perubahan
  if ($src_width >= 200) {
    $dst_width = 200;
  } else {
    $dst_width = $src_width;
  }
  $dst_height = ($dst_width / $src_width) * $src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width, $dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im, $vdir_upload . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im, $vdir_upload . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im, $vdir_upload . $fupload_name);
      break;
  }


  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width2 = 110;
  $dst_height2 = ($dst_width2 / $src_width) * $src_height;

  //proses perubahan ukuran
  $im2 = imagecreatetruecolor($dst_width2, $dst_height2);
  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

  //Simpan gambar
  switch ($imageType) {
    case "image/gif":
      imagegif($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/pjpeg":
    case "image/jpeg":
    case "image/jpg":
      imagejpeg($im2, $vdir_upload . "small_" . $fupload_name);
      break;
    case "image/png":
    case "image/x-png":
      imagepng($im2, $vdir_upload . "small_" . $fupload_name);
      break;
  }

  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
  imagedestroy($im2);
}
