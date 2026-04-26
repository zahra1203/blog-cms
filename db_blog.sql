-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 11:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `id_penulis` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `hari_tanggal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `id_penulis`, `id_kategori`, `judul`, `isi`, `gambar`, `hari_tanggal`) VALUES
(2, 2, 1, 'Best 5th Generation Leader: Shin Junghwan', 'Shinyu memiliki nama asli Shin Jung Hwan. Dia lahir di kota Yesan, provinsi Chungcheongnam, Korea Selatan. Lalu dia juga memiliki dua kakak perempuan yang lahir pada 1997 dan 2002. \r\n\r\nDia lahir pada 7 November 2003, dengan begitu Shinyu memiliki zodiak scorpio dan shio kambing. Shinyu juga merupakan salah satu member tertinggi. Dalam interview di salah satu majalah, ia mengungkapkan tingginya adalah 181 cm.', 'artikel_69edd8b781d709.64185387.jpeg', 'Minggu, 26 April 2026 | 15:01'),
(3, 3, 2, 'Trendsetter \"Angtal Challenge\": Kim Dohoon', 'Kim Dohoon (김도훈) adalah salah satu anggota boy group rookie Korea Selatan bernama TWS yang berada di bawah naungan PLEDIS Entertainment (HYBE Labels). Ia dikenal sebagai idol generasi baru yang memiliki visual menarik, kemampuan performa yang kuat, serta karisma yang menonjol di atas panggung. Nama Kim Dohoon semakin populer karena ia dikenal sebagai trendsetter dari “Angtal Challenge” yang sempat viral di media sosial.\r\n\r\nKim Dohoon lahir pada 30 Januari 2005 di Korea Selatan. Sejak usia muda, ia sudah menunjukkan ketertarikan terhadap dunia hiburan, khususnya dalam bidang menari dan tampil di depan publik. Ketertarikan tersebut membawanya menjalani masa trainee hingga akhirnya terpilih untuk debut bersama TWS.\r\n\r\nKim Dohoon resmi debut bersama TWS pada tahun 2024. Grup ini menarik perhatian besar karena menjadi boy group baru PLEDIS setelah SEVENTEEN. TWS dikenal dengan konsep yang fresh, youthful, dan penuh energi, sehingga berhasil mencuri perhatian banyak penggemar K-pop. Dalam grup, Kim Dohoon sering menjadi sorotan karena pembawaannya yang percaya diri, ekspresi yang kuat, serta gaya yang modern dan mudah dikenali.\r\n\r\nPopularitas Kim Dohoon semakin meningkat setelah dirinya dikenal sebagai trendsetter “Angtal Challenge.” Challenge tersebut menjadi viral karena gerakannya yang unik, ekspresif, dan mudah diikuti. Banyak penggemar hingga pengguna media sosial lain ikut menirukan challenge tersebut, sehingga membuat nama Kim Dohoon semakin dikenal luas.\r\n\r\nSelain kemampuan panggungnya, Kim Dohoon juga dikenal memiliki kepribadian ceria dan ramah. Ia sering menunjukkan interaksi yang hangat dengan para member TWS maupun penggemar. Dengan bakat dan pengaruhnya yang terus berkembang, Kim Dohoon dipandang sebagai salah satu idol muda yang memiliki potensi besar untuk bersinar lebih jauh di industri hiburan Korea Selatan.', 'artikel_69edd570194e16.97483200.jpeg', 'Minggu, 26 April 2026 | 15:19'),
(4, 4, 3, 'Golden Voice: Choi Youngjae', 'Choi Youngjae dikenal memiliki vokal yang jernih dan kuat. Ia mampu membawakan bagian-bagian lagu dengan emosional dan stabil, baik saat rekaman maupun saat tampil live di atas panggung. Hal inilah yang membuat banyak penggemar menganggapnya sebagai salah satu vokalis berbakat yang akan semakin bersinar di masa depan.\r\n\r\nSelain kemampuan vokalnya, Youngjae juga dikenal memiliki kepribadian yang hangat dan tenang. Ia sering menunjukkan sikap ramah kepada penggemar serta menjaga kekompakan dengan para member lainnya. Dengan bakat dan pesona yang dimilikinya, Choi Youngjae dipandang sebagai salah satu idol generasi baru yang memiliki potensi besar untuk menjadi vokalis terkenal di industri K-pop.', 'artikel_69edd27aab7213.81318650.jpeg', 'Minggu, 26 April 2026 | 15:53'),
(5, 5, 1, 'The China \'IT BOY\': Han Zhen', 'Han Zhen (韩震) dikenal sebagai salah satu figur muda yang sering dijuluki “China IT BOY” karena pesona visualnya, gaya fashion yang modern, serta pengaruhnya yang kuat di media sosial. Julukan “IT BOY” sendiri biasanya diberikan kepada sosok pria yang dianggap paling trendi, menarik perhatian publik, dan menjadi panutan dalam gaya hidup maupun fashion.\r\n\r\nHan Zhen mulai dikenal luas karena penampilannya yang karismatik dan aura elegan yang mudah mencuri perhatian. Ia memiliki wajah yang tegas namun tetap terlihat youthful, sehingga membuatnya cocok menjadi ikon fashion dan visual di kalangan generasi muda. Banyak penggemar menganggap Han Zhen sebagai representasi “pria ideal” karena kombinasi antara penampilan yang stylish dan pembawaan yang percaya diri.\r\n\r\nSelain visual, Han Zhen juga dikenal karena selera fashion yang kuat. Ia sering tampil dengan gaya streetwear maupun outfit formal yang terlihat simple tetapi tetap mahal dan classy. Cara Han Zhen membawa dirinya dalam berbagai kesempatan membuatnya dianggap sebagai sosok yang mampu menciptakan tren baru, bukan hanya mengikuti tren yang sudah ada.\r\n\r\nPopularitas Han Zhen semakin meningkat seiring dengan berkembangnya media sosial. Banyak konten tentang dirinya viral di berbagai platform karena gaya, ekspresi, dan vibe yang dianggap “berkelas.” Ia juga sering dibicarakan karena memiliki aura bintang yang kuat, sehingga tidak sedikit orang yang memprediksi bahwa Han Zhen akan terus berkembang menjadi figur besar di industri hiburan maupun fashion China.\r\n\r\nDengan visual yang menonjol, gaya yang fashionable, serta pengaruh yang besar di kalangan anak muda, Han Zhen layak disebut sebagai salah satu “IT BOY” paling bersinar di China saat ini.', 'artikel_69edd565012a55.14216222.jpeg', 'Minggu, 26 April 2026 | 15:57'),
(6, 6, 2, 'Dancing Machine: Han Jihoon', 'Han Jihoon menjadi salah satu member yang paling menonjol karena performanya yang selalu memukau,sebagai “Dancing Machine,” Han Jihoon dikenal memiliki teknik menari yang baik, kontrol tubuh yang kuat, serta kemampuan mengekspresikan lagu melalui gerakan yang detail. Ia juga mampu membawakan koreografi yang sulit dengan terlihat mudah dan natural, membuatnya sering menjadi sorotan dalam penampilan live maupun video dance practice.\r\n\r\nSelain kemampuan menari, Han Jihoon juga dikenal memiliki kepribadian yang ceria dan ramah. Ia sering menunjukkan interaksi hangat dengan para member serta penggemar. Kombinasi antara bakat menari, visual yang menarik, dan energi yang kuat menjadikan Han Jihoon sebagai salah satu idol muda yang memiliki potensi besar untuk terus bersinar di industri K-pop.', 'artikel_69edd4e6c7a774.80919979.jpeg', 'Minggu, 26 April 2026 | 16:03'),
(7, 7, 3, 'Youngest Unique Highnote: Lee Kyungmin', 'Sebagai member termuda, Lee Kyungmin sering menjadi sorotan karena aura youthful yang fresh serta pembawaannya yang ceria. Ia mampu menciptakan suasana hangat dan menyenangkan, sehingga banyak penggemar menganggapnya sebagai sosok yang membawa energi positif di dalam grup. Kepribadiannya yang lucu dan ramah membuatnya mudah disukai oleh penggemar.\r\n\r\nJulukan “Unique Highnote” muncul karena suara Lee Kyungmin dianggap memiliki ciri khas yang lembut namun kuat, serta mampu mencapai nada tinggi dengan stabil. Kemampuannya tersebut membuat penampilannya semakin menonjol, baik dalam rekaman lagu maupun saat tampil secara live. Banyak penggemar menilai bahwa vokalnya memberikan sentuhan yang berbeda dan memperindah harmoni dalam lagu-lagu yang dibawakan.\r\n\r\nSelain kemampuan vokalnya, Lee Kyungmin juga dikenal memiliki ekspresi panggung yang menarik dan karisma yang berkembang pesat. Ia mampu menyesuaikan diri dengan konsep grup dan tetap menunjukkan identitas uniknya sendiri. Hal ini membuatnya semakin dikenal sebagai idol muda berbakat dengan potensi besar.', 'artikel_69edd7c86b90c3.06002292.jpeg', 'Minggu, 26 April 2026 | 16:15');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'Biografi', 'Biografi Idol'),
(2, 'Entertainment', 'pencipta trend dalam bidang industri hiburan'),
(3, 'Singer', 'Penyanyi terkenal yang memiliki suara indah');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(100) NOT NULL,
  `nama_belakang` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id`, `nama_depan`, `nama_belakang`, `user_name`, `password`, `foto`) VALUES
(2, 'Shin', 'Junghwan', 'sjh_tws', '247withus', 'foto_69edbcf468dda.jpg'),
(3, 'Kim', 'Dohoon', 'kdh_tws', '247withus', 'foto_69edbf45618fb.jpg'),
(4, 'Choi', 'Youngjae', 'cyj_tws', '247withus', 'foto_69edbf604386d.jpg'),
(5, 'Han', 'Zhen', 'hzn_tws', '247withus', 'foto_69edbf79db9e5.jpg'),
(6, 'Han', 'Jihoon', 'hjh_tws', '247withus', 'foto_69edc2c40b85e.jpg'),
(7, 'Lee', 'Kyungmin', 'lkm_tws', '247withus', 'foto_69edc2e222794.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_penulis` (`id_penulis`),
  ADD KEY `fk_artikel_kategori` (`id_kategori`);

--
-- Indexes for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_artikel` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_artikel_penulis` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
