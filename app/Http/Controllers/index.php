<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>EventEast - Jelajah Konser & Event Musik</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

<?php include 'header.php'; ?>

<!-- CAROUSEL BANNER -->
<div class="relative w-full h-[512px] overflow-hidden">
  <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
    <img src="../project eventeast/foto/Screenshot 2025-06-10 230919.png"
         class="w-full flex-shrink-0 h-full object-cover" alt="Slide 1" />
    <img src="../project eventeast/foto/Screenshot 2025-06-10 231057.png"
         class="w-full flex-shrink-0 h-full object-cover" alt="Slide 2" />
    <img src="../project eventeast/foto/Screenshot 2025-06-10 230941.png"
         class="w-full flex-shrink-0 h-full object-cover" alt="Slide 3" />
  </div>

  <!-- Carousel controls -->
  <button onclick="prevSlide()" class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-full hover:bg-black/60">&#10094;</button>
  <button onclick="nextSlide()" class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/40 text-white px-3 py-2 rounded-full hover:bg-black/60">&#10095;</button>
</div>

<!--Kategori Genre-->
<section class="container mx-auto px-6 mt-14">
  <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Kategori Musik Populer</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-8 max-w-6xl mx-auto">
    <?php
      //Array multidimensi
       $categories = [
        ['icon' => 'https://img.icons8.com/dotty/80/bass-guitar.png', 'name' => 'Rock'],
        ['icon' => 'https://img.icons8.com/ios7/80/micro.png', 'name' => 'Pop'],
        ['icon' => 'https://img.icons8.com/ios7/80/jazz.png', 'name' => 'Jazz'],
        ['icon' => 'https://img.icons8.com/ios7/80/guitar.png', 'name' => 'Indie'],
        ['icon' => 'https://img.icons8.com/ios11/80/ellipsis.png', 'name' => 'Lainnya'],
      ];      
      foreach ($categories as $cat) {
        echo '<a href="../project eventeast/event/eventByKategori.php?kategori='.urlencode($cat['name']).'" class="bg-white rounded-lg shadow p-6 text-center cursor-pointer hover:shadow-lg transition block">
                <img src="'.$cat['icon'].'" alt="'.$cat['name'].'" class="mx-auto mb-4 w-14" />
                <p class="font-semibold text-gray-800 text-lg">'.$cat['name'].'</p>
              </a>';
      }
    ?>
  </div>
</section>



<!-- KATEGORI EVENT TERBARU -->
<section class="max-w-screen-xl mx-auto px-4 mt-20">
  <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Konser & Event Musik Terbaru</h2>

  <div class="flex overflow-x-auto gap-4 pb-4 hide-scrollbar">
    <?php
      include '../project eventeast/koneksi/conn.php';

      $query = "SELECT * FROM tb_events WHERE status = 'disetujui' ORDER BY event_date DESC LIMIT 6";
      $result = mysqli_query($conn, $query);

      if (!$result) {
        die("Query Error: " . mysqli_error($conn));
      }

      if (mysqli_num_rows($result) > 0) {
        while ($e = mysqli_fetch_assoc($result)) {
          $imageName = $e['event_image']; // Dari database
          $title = htmlspecialchars($e['event_title']);
          $date = date("d F Y", strtotime($e['event_date']));
          $location = htmlspecialchars($e['event_location']);
          $id = $e['event_id'];

          $img_path = '';
          $default_image = '../project eventeast/assets/images/placeholder.jpg';
          
          if (!empty($imageName)) {
            // Jika path di database sudah lengkap (termasuk folder uploads/)
            if (strpos($imageName, 'uploads/') !== false) {
              $img_path = '../project eventeast/event/' . $imageName;
            } else {
              // Jika hanya nama file saja
              $img_path = '../project eventeast/event/uploads/' . $imageName;
            }
            
            // Cek apakah file benar-benar ada
            if (!file_exists($img_path)) {
              // Coba path alternatif
              $alternative_paths = [
                '../project eventeast/uploads/' . $imageName,
                'uploads/' . $imageName,
                $imageName // Jika path sudah absolute
              ];
              
              $found = false;
              foreach ($alternative_paths as $alt_path) {
                if (file_exists($alt_path)) {
                  $img_path = $alt_path;
                  $found = true;
                  break;
                }
              }
              
              // Jika tidak ditemukan, gunakan default
              if (!$found) {
                $img_path = $default_image;
              }
            }
          } else {
            $img_path = $default_image;
          }

          // Validasi ekstensi file
          $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
          $file_ext = strtolower(pathinfo($img_path, PATHINFO_EXTENSION));
          
          if (!in_array($file_ext, $allowed_extensions)) {
            $img_path = $default_image;
          }

          $price = number_format($e['price'], 0, ',', '.'); // Format harga rupiah

          echo '<div class="flex-shrink-0 w-60 bg-white rounded-xl shadow-md hover:shadow-lg transition overflow-hidden">';
          echo '<div class="relative">';
          echo '<img src="'.$img_path.'" alt="'.$title.'" class="w-full h-40 object-cover" onerror="this.src=\''.$default_image.'\'" />';
          echo '<div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">';
          echo htmlspecialchars($e['event_category'] ?? 'Event');
          echo '</div>';
          echo '</div>';
          echo '<div class="p-4">';
          echo '<h3 class="font-semibold text-base mb-1 line-clamp-2">'.$title.'</h3>';
          echo '<p class="text-sm text-gray-600 mb-1">'.$date.' | '.$location.'</p>';
          echo '<p class="text-sm font-semibold text-blue-900 mb-2">Mulai dari Rp '.$price.'</p>';
          echo '<div class="flex gap-2">';
          echo '<a href="../project eventeast/event/detail.php?id='.$id.'" class="bg-blue-900 text-white text-sm px-3 py-1 rounded hover:bg-blue-800 transition inline-block">Lihat Detail</a>';
          echo '<a href="../project eventeast/tiket/findTicket.php?id='.$id.'" class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-500 transition inline-block">Beli Tiket</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

        }
      } else {
        echo '<div class="flex-shrink-0 w-full text-center py-8">';
        echo '<p class="text-gray-600">Belum ada event tersedia saat ini.</p>';
        echo '</div>';
      }
    ?>
  </div>
</section>


<style>
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>

<style>
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>



<!-- INFO -->
<section class="bg-white mt-24 py-16">
  <div class="container mx-auto px-6 max-w-4xl text-center">
    <h2 class="text-3xl font-bold mb-6 text-gray-900">Kenapa Pilih EventEast?</h2>
    <p class="text-gray-700 text-lg mb-12">Kami menyediakan pengalaman terbaik dalam menjelajah event musik dengan kemudahan pembelian tiket dan informasi lengkap.</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-yellow-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
        <h4 class="font-semibold mb-1">Beli Tiket Mudah</h4>
        <p class="text-gray-600 text-sm">Pembelian tiket cepat dan aman langsung dari penyelenggara resmi.</p>
      </div>
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-yellow-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
        <h4 class="font-semibold mb-1">Event Terupdate</h4>
        <p class="text-gray-600 text-sm">Kami selalu memperbarui event terbaru dan terpopuler di kota kamu.</p>
      </div>
      <div>
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-yellow-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
        <h4 class="font-semibold mb-1">Dukungan Pelanggan</h4>
        <p class="text-gray-600 text-sm">Tim support kami siap membantu kamu kapan saja.</p>
      </div>
    </div>
  </div>
</section>

<!-- ORGANIZER POPULER -->
<section class="bg-gray-100 py-16 mt-16">
  <div class="container mx-auto px-6 max-w-6xl">
    <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Most Happening Organizers in Bandung</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

      <?php
      include '../project eventeast/koneksi/conn.php';

      $q = "SELECT ID, username, foto FROM tb_users WHERE role = 'Penyelenggara' LIMIT 3";
      $r = mysqli_query($conn, $q);

      while ($org = mysqli_fetch_assoc($r)) {
        $id = $org['ID'];
        $name = htmlspecialchars($org['username']);
        $foto = $org['foto'];
        $avatarBg = "1976d2"; // Warna biru default untuk avatar
        
        // Cek apakah ada foto profil
        if (!empty($foto) && file_exists($basePath . $foto)) {
          $imgSrc = $basePath . $foto;
        } else {
          $imgSrc = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=$avatarBg&color=fff&size=128";
        }

        echo '<div class="bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">';
        echo '<img src="'.$imgSrc.'" alt="'.$name.'" class="mx-auto w-16 h-16 object-cover rounded-full mb-4" onerror="this.src=\'https://ui-avatars.com/api/?name='.urlencode($name).'&background='.$avatarBg.'&color=fff&size=128\'" />';
        echo '<h4 class="text-xl font-semibold text-gray-800 mb-2">'.$name.'</h4>';
        echo '<a href="../project eventeast/dashboard/penyelenggara/detailPenyelenggara.php?id='.$id.'" class="inline-block bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Lihat Event</a>';
        echo '</div>';
      }
      ?>

    </div>
  </div>
</section>


<script>
  const carousel = document.getElementById('carousel');
  let index = 0;
  const totalSlides = carousel.children.length;

  function showSlide(i) {
    const width = carousel.clientWidth;
    carousel.style.transform = `translateX(-${i * width}px)`;
  }

  function nextSlide() {
    index = (index + 1) % totalSlides;
    showSlide(index);
  }

  function prevSlide() {
    index = (index - 1 + totalSlides) % totalSlides;
    showSlide(index);
  }

  // Optional: auto-slide
  setInterval(() => {
    nextSlide();
  }, 5000);
</script>




<?php include 'footer.php'; ?>

</body>
</html>