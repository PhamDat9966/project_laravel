-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 09, 2025 lúc 06:29 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `proj_news`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timeMeet` datetime NOT NULL,
  `phonenumber` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `appoint` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `branch_info` text DEFAULT NULL,
  `note` text NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `appointment`
--

INSERT INTO `appointment` (`id`, `name`, `timeMeet`, `phonenumber`, `email`, `appoint`, `sex`, `branch_id`, `branch_info`, `note`, `status`) VALUES
(2, 'Member001', '2024-08-01 12:00:00', 22345678, 'test@gmail.com', 'dv1', 'nam', 1, NULL, '3231 1daasda sadsad xc', 'inactive'),
(3, 'Phamdat123123213', '2024-08-01 12:00:00', 12345678, 'admin@gmail.com', 'dv1', 'nam', 2, NULL, 'dasdas daasdasd dasdas dsa dá', 'inactive'),
(4, 'Member0011', '2024-08-01 12:00:00', 22345678, 'admin@gmail.com', 'dv1', 'nu', 2, NULL, '312a add dá dsadas d đâs', 'inactive'),
(5, 'test01', '2024-08-03 12:00:00', 12345678, 'test@gmail.com', 'science', 'nam', 1, 'Chi nhánh 1 -Tầng 5, Tòa nhà Songdo, 62A Phạm Ngọc Thạch, Phường 6, Quận 3, Hồ Chí Minh', '123123123123', 'active'),
(6, 'Dat123', '2024-08-03 12:00:00', 12345678, 'test@gmail.com', 'science', 'nam', 2, 'Chi nhánh 2- 757C Kha Vạn Cân, P.Linh Tây, Thủ Đức, Hcm', '312321321 312312  asaas cxzc xcas', 'inactive'),
(7, 'Member00111', '2024-08-06 12:00:00', 22345678, 'admin@gmail.com', 'book', 'nam', 3, 'Chi nhánh 3- 523 Đỗ Xuân Hợp, Block C chung cư The Art, KDCQ10', 'Member00111', 'inactive'),
(8, 'Member002', '2024-08-07 12:00:00', 12345678, 'test@gmail.com', 'science', 'nam', 2, 'Chi nhánh 2- 757C Kha Vạn Cân, P.Linh Tây, Thủ Đức, Hcm', 'dsadasdasd dasda', 'inactive'),
(9, 'Phamdat123123213', '2024-08-20 12:00:00', 12345678, 'phamdat9966@gmail.com', 'science', 'nam', 1, 'Chi nhánh 1 - Tầng 5, Tòa nhà Songdo, 62A Phạm Ngọc Thạch, Phường 6, Quận 3, Hồ Chí Minh', 'test', 'inactive');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` varchar(225) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `publish_at` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `article`
--

INSERT INTO `article` (`id`, `category_id`, `name`, `slug`, `content`, `status`, `thumb`, `created`, `created_by`, `modified`, `modified_by`, `publish_at`, `type`) VALUES
(4, 2, 'Liverpool chỉ được nâng Cup phiên bản nếu vô địch hôm nay', 'bv-liverpool-chi-duoc-nang-cup-phien-ban-neu-vo-dich-hom-nay-4', '<p>Đội b&oacute;ng th&agrave;nh phố cảng sẽ kh&ocirc;ng n&acirc;ng Cup nguy&ecirc;n bản nếu vượt mặt Man City ở v&ograve;ng cuối Ngoại hạng Anh.</p>\n\n<p>Liverpool k&eacute;m Man City một điểm trước khi tiếp Wolverhampton tr&ecirc;n s&acirc;n nh&agrave; Anfield v&agrave;o ng&agrave;y Chủ Nhật. Ở trận đấu c&ugrave;ng giờ, Man City sẽ l&agrave;m kh&aacute;ch tới s&acirc;n Brighton v&agrave; biết một chiến thắng sẽ gi&uacute;p họ bảo vệ th&agrave;nh c&ocirc;ng ng&ocirc;i v&ocirc; địch. Kể từ khi c&aacute;c trận v&ograve;ng cuối Ngoại hạng Anh sẽ chơi đồng loạt c&ugrave;ng l&uacute;c, ban tổ chức phải đặt một chiếc cup phi&ecirc;n bản giống thật tại Anfield ph&ograve;ng trường hợp Liverpool v&ocirc; địch. Chiếc cup giả n&agrave;y thường được d&ugrave;ng trong c&aacute;c sự kiện quảng b&aacute; của Ngoại hạng Anh.&nbsp;</p>', 'active', 'L3Yuzln8II.png', '2024-05-01 00:00:00', 'hailan', '2024-09-19 00:00:00', 'admin', '2019-04-29', 'normal'),
(5, 2, 'Bottas giành pole chặng thứ ba liên tiếp', NULL, '<p>Tay đua Phần Lan đ&aacute;nh bại đồng đội Lewis Hamilton ở v&ograve;ng ph&acirc;n hạng GP T&acirc;y Ban Nha h&ocirc;m 11/5.</p>\r\n\r\n<p>Valtteri Bottas nhanh hơn Hamilton 0,634 gi&acirc;y v&agrave; nhanh hơn người về thứ ba&nbsp;Sebastian Vettel 0,866 gi&acirc;y. Tay đua của Red Bull&nbsp;Max Verstappen nhanh thứ tư, trong khi&nbsp;Charles Leclerc về thứ năm.</p>', 'active', 'iQ1RXPioFZ.jpeg', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-04-28', 'normal'),
(6, 2, 'HLV Cardiff: \'Man Utd sẽ không vô địch trong 10 năm tới\'', 'bv-hlv-cardiff-man-utd-se-khong-vo-dich-trong-10-nam-toi-6', '<p>Neil Warnock tỏ ra nghi ngờ về tương lai của Man Utd dưới thời HLV Solskjaer.</p>\n\n<p>&quot;Một số người nghĩ Man Utd cần từ hai đến ba kỳ chuyển nhượng nữa để gi&agrave;nh danh hiệu&quot;, HLV Neil Warnock chia sẻ. &quot;T&ocirc;i th&igrave; nghĩ c&oacute; thể l&agrave; 10 năm. T&ocirc;i kh&ocirc;ng thấy học&oacute; khả năng bắt kịp hai CLB h&agrave;ng đầu trong khoảng bốn hay năm năm tới&quot;.</p>\n\n<p>Lần cuối Man Utd v&ocirc; địch l&agrave; m&ugrave;a 2012-2013 dưới thời HLV Sir Alex Ferguson. Kể từ đ&oacute; đến nay, &quot;Quỷ đỏ&quot; kh&ocirc;ng c&ograve;n duy tr&igrave; được vị thế ứng cử vi&ecirc;n v&ocirc; địch h&agrave;ng đầu.&nbsp;</p>', 'active', 'ReChSfB95C.jpeg', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-30', 'feature'),
(7, 6, 'Đại học Anh đưa khóa học hạnh phúc vào chương trình giảng dạy', 'bv-dai-hoc-anh-dua-khoa-hoc-hanh-phuc-vao-chuong-trinh-giang-day-7', '<p>Kh&oacute;a học diễn ra trong 12 tuần, sinh vi&ecirc;n năm nhất Đại học Bristol sẽ được kh&aacute;m ph&aacute; hạnh ph&uacute;c l&agrave; g&igrave; v&agrave; l&agrave;m thế n&agrave;o để đạt được n&oacute;.</p>\r\n\r\n<p>Đại học Bristol (Anh) quyết định đưa kh&oacute;a học hạnh ph&uacute;c v&agrave;o giảng dạy từ th&aacute;ng 9 năm nay nhằm giảm thiểu t&igrave;nh trạng tự tử ở sinh vi&ecirc;n, sau khi 12 sinh vi&ecirc;n ở một trường kh&aacute;c quy&ecirc;n sinh trong ba năm qua. Gi&aacute;o sư Bruce Hood, nh&agrave; t&acirc;m l&yacute; học chuy&ecirc;n nghi&ecirc;n cứu về c&aacute;ch thức hoạt động của bộ n&atilde;o v&agrave; con người, sẽ giảng dạy m&ocirc;n học mới n&agrave;y.</p>', 'active', 'hoyOyXJrzx.png', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-05', 'normal'),
(8, 6, '11 cách đơn giản dạy trẻ quản lý thời gian', 'bv-11-cach-don-gian-day-tre-quan-ly-thoi-gian-8', '<p>Phụ huynh h&atilde;y tạo cảm gi&aacute;c vui vẻ, hướng dẫn trẻ thiết lập những ưu ti&ecirc;n h&agrave;ng ng&agrave;y để ch&uacute;ng c&oacute; thể tự quản l&yacute; thời gian hiệu quả.</p>\r\n\r\n<p>&quot;Nhanh l&ecirc;n&quot;, &quot;Con c&oacute; biết mấy giờ rồi kh&ocirc;ng&quot;, &quot;Điều g&igrave; l&agrave;m con mất nhiều thời gian như vậy&quot;..., l&agrave; những c&acirc;u n&oacute;i quen thuộc của phụ huynh để nhắc nhở con về kh&aacute;i niệm thời gian. Thay v&igrave; n&oacute;i những c&acirc;u tr&ecirc;n, phụ huynh c&oacute; thể dạy con c&aacute;ch quản l&yacute; giờ giấc ngay từ khi ch&uacute;ng c&ograve;n nhỏ.</p>', 'active', 'Phe2pSOC5Q.jpeg', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-07-30', 'normal'),
(9, 4, 'Vì sao không hút thuốc vẫn bị ung thư phổi?', 'bv-vi-sao-khong-hut-thuoc-van-bi-ung-thu-phoi-9', '<p>D&ugrave; kh&ocirc;ng h&uacute;t thuốc, bạn vẫn c&oacute; nguy cơ ung thư phổi do h&iacute;t phải kh&oacute;i thuốc, tiếp x&uacute;c với kh&iacute; radon hoặc sống trong m&ocirc;i trường &ocirc; nhiễm.&nbsp;</p>\r\n\r\n<p>Người kh&ocirc;ng h&uacute;t thuốc vẫn c&oacute; thể bị ung thư phổi.&nbsp;Tr&ecirc;n&nbsp;<em>Journal of the Royal Society of Medicine</em>,&nbsp;c&aacute;c nh&agrave; khoa học từ&nbsp;Hiệp hội Ung thư Mỹ cho biết 20% bệnh nh&acirc;n ung thư phổi kh&ocirc;ng bao giờ h&uacute;t thuốc.&nbsp;Nghi&ecirc;n cứu 30 năm tr&ecirc;n 1,2 triệu người của tổ chức n&agrave;y cũng chỉ ra số người kh&ocirc;ng h&uacute;t thuốc bị ung thư phổi đang gia tăng. Hầu hết bệnh nh&acirc;n chỉ được chẩn đo&aacute;n khi đ&atilde; bước sang giai đoạn nghi&ecirc;m trọng kh&ocirc;ng thể điều trị.&nbsp;</p>', 'active', 'tPa7bgOesm.png', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-08-30', 'normal'),
(10, 6, '10 hãng hàng không  tốt nhất thế giới năm 2019', 'bv-10-hang-hang-khong-tot-nhat-the-gioi-nam-2019-10', '<p>Qatar l&agrave; quốc gia duy nhất tr&ecirc;n thế giới c&oacute; h&atilde;ng h&agrave;ng kh&ocirc;ng v&agrave; s&acirc;n bay tốt nhất năm 2019.</p>\r\n\r\n<p>C&aacute;c s&acirc;n bay được đ&aacute;nh gi&aacute; dựa tr&ecirc;n 3 yếu tố: hiệu suất đ&uacute;ng giờ, chất lượng dịch vụ, thực phẩm v&agrave; lựa chọn mua sắm. Yếu tố đầu ti&ecirc;n chiếm 60% số điểm, hai ti&ecirc;u ch&iacute; c&ograve;n lại chiếm 20%. Dữ liệu của AirHelp được dựa tr&ecirc;n thống k&ecirc; từ nhiều nh&agrave; cung cấp thương mại, c&ugrave;ng cơ sở dữ liệu đ&aacute;nh gi&aacute; ri&ecirc;ng v&agrave; 40.000 khảo s&aacute;t h&agrave;nh kh&aacute;ch được thu thập từ hơn 40 quốc gia trong năm 2018.</p>', 'active', '8GlYE3KYtZ.png', '2019-05-04 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-09-30', 'normal'),
(11, 6, 'Phát hiện bụt mọc cổ thụ hơn 2.600 tuổi ở Mỹ', 'bv-phat-hien-but-moc-co-thu-hon-2600-tuoi-o-my-11', '<p>Ph&aacute;t hiện mới gi&uacute;p bụt mọc trở th&agrave;nh một trong những c&acirc;y sinh sản hữu t&iacute;nh gi&agrave; nhất thế giới, vượt xa ước t&iacute;nh trước đ&acirc;y của c&aacute;c chuy&ecirc;n gia.</p>\r\n\r\n<p>C&aacute;c nh&agrave; khoa học ph&aacute;t hiện một c&acirc;y bụt mọc &iacute;t nhất đ&atilde; 2.624 tuổi ở v&ugrave;ng đầm lầy s&ocirc;ng Black, bang Bắc Carolina, Mỹ, theo nghi&ecirc;n cứu đăng tr&ecirc;n tạp ch&iacute;&nbsp;<em>Environmental Research Communications</em>&nbsp;h&ocirc;m 9/5.&nbsp;</p>\r\n\r\n<p>Nh&oacute;m nghi&ecirc;n cứu bắt gặp bụt mọc cổ thụ n&agrave;y trong l&uacute;c nghi&ecirc;n cứu v&ograve;ng tuổi của c&acirc;y để t&igrave;m hiểu về lịch sử kh&iacute; hậu tại miền đ&ocirc;ng nước Mỹ. Ngo&agrave;i thể hiện tuổi thọ, độ rộng v&agrave; m&agrave;u sắc của v&ograve;ng tuổi tr&ecirc;n th&acirc;n c&acirc;y c&ograve;n cho biết mức độ ẩm ướt hay kh&ocirc; hạn của năm tương ứng.</p>', 'active', 'a09zB7BiwV.jpeg', '2019-05-12 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-12', 'normal'),
(12, 6, 'Apple có thể không nâng cấp iOS 13 cho iPhone SE, 6', 'bv-apple-co-the-khong-nang-cap-ios-13-cho-iphone-se-6-12', '<p>Những mẫu iPhone ra mắt từ 2014 v&agrave; iPhone SE c&oacute; thể kh&ocirc;ng được l&ecirc;n đời hệ điều h&agrave;nh iOS 13 ra mắt th&aacute;ng 6 tới.</p>\r\n\r\n<p>Theo&nbsp;<em>Phone Arena</em>, hệ điều h&agrave;nh iOS 13 sắp tr&igrave;nh l&agrave;ng tại hội nghị WWDC 2019 sẽ kh&ocirc;ng hỗ trợ một loạt iPhone đời cũ của Apple. Trong đ&oacute;, đ&aacute;ng ch&uacute; &yacute; l&agrave; c&aacute;c mẫu iPhone vẫn c&ograve;n được nhiều người d&ugrave;ng sử dụng như iPhone 6, 6s Plus hay SE.&nbsp;</p>', 'active', '9jOZGc7BJK.png', '2019-05-12 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(13, 8, 'Hình dung về Honda Jazz thế hệ mới', 'bv-hinh-dung-ve-honda-jazz-the-he-moi-13', '<p>Thế hệ thứ tư của mẫu hatchback Honda tiết chế bớt những đường n&eacute;t g&acirc;n guốc, thể thao để thay bằng n&eacute;t trung t&iacute;nh, hợp mắt người d&ugrave;ng hơn.&nbsp;</p>\r\n\r\n<p>Những h&igrave;nh ảnh đầu ti&ecirc;n về Honda Jazz (Fit tại Nhật Bản) thế hệ mới bắt đầu xuất hiện tr&ecirc;n đường thử. D&ugrave; chưa phải thiết kế ho&agrave;n chỉnh, thay đổi của mẫu hatchback cỡ B cho thấy những đường n&eacute;t trung t&iacute;nh m&agrave; xe sắp sở hữu. Điều n&agrave;y tr&aacute;i ngược với tạo h&igrave;nh g&acirc;n guốc, thể thao ở thế hệ thứ ba hiện tại của Jazz.&nbsp;</p>', 'active', 'g2c7mYXBPW.png', '2019-05-12 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-12', 'normal'),
(14, 2, 'Hà Nội vào vòng knock-out AFC Cup', 'bv-ha-noi-vao-vong-knock-out-afc-cup-14', '<p>ĐKVĐ V-League đ&aacute;nh bại&nbsp;Tampines Rovers 2-0 v&agrave;o chiều 15/5 để đứng đầu bảng F.</p>\r\n\r\n<p>Tiếp đối thủ đến từ Singapore trong t&igrave;nh thế buộc phải thắng để tự quyết v&eacute; đi tiếp, H&agrave; Nội đ&atilde; c&oacute; trận đấu dễ d&agrave;ng. C&oacute; thể n&oacute;i, kết quả của trận đấu được định đoạt trong hiệp một khi Oseni v&agrave; Th&agrave;nh Chung lần lượt ghi b&agrave;n cho đội chủ nh&agrave;. Trong khi đ&oacute;, Tampines Rovers phải trả gi&aacute; cho lối chơi th&ocirc; bạo khi Yasir Hanapi nhận thẻ v&agrave;ng thứ hai rời s&acirc;n. Tiền vệ n&agrave;y bị trừng phạt bởi pha đ&aacute;nh nguội với Th&agrave;nh Chung ở đầu trận, sau đ&oacute; l&agrave; t&igrave;nh huống phạm lỗi &aacute;c &yacute; với Đ&igrave;nh Trọng.</p>', 'active', 'e7YyFZJCc8.jpeg', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(15, 2, 'Man City vẫn dự Champions League mùa 2019-2020', 'bv-man-city-van-du-champions-league-mua-2019-2020-15', '<p>Việc điều tra vi phạm luật c&ocirc;ng bằng t&agrave;i ch&iacute;nh của chủ s&acirc;n Etihad chưa thể ho&agrave;n th&agrave;nh trong v&ograve;ng một năm tới.</p>\n\n<p><em>Sports Mail</em>&nbsp;(Anh)&nbsp;cho biết, &aacute;n phạt cấm tham dự Champions League một m&ugrave;a với Man City, do vi phạm luật c&ocirc;ng bằng t&agrave;i ch&iacute;nh (FFP), chỉ được đưa ra sớm nhất v&agrave;o m&ugrave;a 2020-2021.</p>\n\n<p>Trong bức thư ngỏ gửi tới truyền th&ocirc;ng Anh, Man City viết: &quot;Ch&uacute;ng t&ocirc;i hợp t&aacute;c một c&aacute;ch thiện ch&iacute; với Tiểu ban kiểm so&aacute;t t&agrave;i ch&iacute;nh c&aacute;c CLB của UEFA (CFCB). CLB tin tưởng v&agrave;o sự độc lập v&agrave; cam kết của CFCB h&ocirc;m 7/3, rằng sẽ kh&ocirc;ng kết luận g&igrave; trong thời gian điều tra&quot;.</p>', 'active', 'exzJEG4WDU.jpeg', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(16, 6, 'Những câu đố giúp rèn luyện trí não', 'bv-nhung-cau-do-giup-ren-luyen-tri-nao-16', '<p>Bạn cần quan s&aacute;t, suy luận logic v&agrave; c&oacute; vốn từ vựng tiếng Anh để giải quyết những c&acirc;u đố dưới đ&acirc;y.</p>\r\n\r\n<p>C&acirc;u 1:&nbsp;Mike đến một buổi phỏng vấn xin việc. Anh đ&atilde; g&acirc;y ấn tượng với gi&aacute;m đốc về những kỹ năng v&agrave; kinh nghiệm của m&igrave;nh. Tuy nhi&ecirc;n, để quyết định c&oacute; nhận Mike hay kh&ocirc;ng, nữ gi&aacute;m đốc đưa ra một c&acirc;u đố h&oacute;c b&uacute;a v&agrave; y&ecirc;u cầu Mike trả lời trong 30 gi&acirc;y.</p>\r\n\r\n<p>Nội dung c&acirc;u đố: H&atilde;y đưa ra 30 từ tiếng Anh kh&ocirc;ng c&oacute; chữ &quot;a&quot; xuất hiện trong đ&oacute;?&nbsp;</p>\r\n\r\n<p>Mike dễ d&agrave;ng giải quyết c&acirc;u đố. Theo bạn anh ấy n&oacute;i những từ tiếng Anh n&agrave;o để kịp trả lời trong 30 gi&acirc;y?</p>', 'active', 'TpcocqUjob.png', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(17, 4, 'Cách nhận biết mật ong nguyên chất và pha trộn', 'bv-cach-nhan-biet-mat-ong-nguyen-chat-va-pha-tron-17', '<p>Mật ong nguy&ecirc;n chất sẽ kh&ocirc;ng thấm qua tờ giấy, lắng xuống đ&aacute;y ly nước v&agrave; bị kiến ăn, kh&aacute;c với mật ong bị pha trộn tạp chất.</p>\r\n\r\n<p>Dược sĩ V&otilde; H&ugrave;ng Mạnh, Trưởng khoa Dược Bệnh viện Y học d&acirc;n tộc cổ truyền B&igrave;nh Định, cho biết thị trường c&oacute; nhiều loại mật ong bị pha trộn, chỉ nh&igrave;n bề ngo&agrave;i hay ngửi m&ugrave;i chưa chắc ph&acirc;n biệt được.</p>\r\n\r\n<p>Theo dược sĩ H&ugrave;ng, một c&aacute;ch ph&acirc;n biệt thật giả l&agrave; lấy cọng h&agrave;nh tươi nh&uacute;ng v&agrave;o lọ mật ong, lấy ra chừng v&agrave;i ph&uacute;t. Cọng l&aacute; h&agrave;nh sẽ chuyển từ m&agrave;u xanh l&aacute; sang sậm nếu mật ong thật. Ngo&agrave;i ra, c&oacute; thể nhỏ giọt mật v&agrave;o nơi c&oacute; kiến, nếu kiến kh&ocirc;ng bu giọt mật th&igrave; cũng l&agrave; mật ong thật.</p>\r\n\r\n<p>Ng&agrave;y nay, nhiều người đặt mật ong v&agrave;o ngăn đ&aacute; tủ lạnh, sau 24 giờ m&agrave; kh&ocirc;ng c&oacute; hiện tượng đ&ocirc;ng đ&aacute; th&igrave; l&agrave; mật thật.</p>', 'active', 'xvEqmF5uyJ.png', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(18, 6, 'Nhiều tour mùa hè giảm giá hàng chục triệu đồng', 'bv-nhieu-tour-mua-he-giam-gia-hang-chuc-trieu-dong-18', '<p>C&aacute;c tour trong v&agrave; ngo&agrave;i nước đều được giảm gi&aacute; mạnh để k&iacute;ch cầu du lịch trong dịp h&egrave;, nhiều chương tr&igrave;nh khuyến m&atilde;i l&ecirc;n đến h&agrave;ng chục triệu đồng.</p>\r\n\r\n<p>Sau khi so s&aacute;nh tiền v&eacute; m&aacute;y bay, ph&ograve;ng kh&aacute;ch sạn ở Bali để chuẩn bị cho kỳ nghỉ h&egrave; của gia đ&igrave;nh, anh Sơn (ngụ quận 2, TP HCM) quyết định chuyển sang mua tour trọn g&oacute;i v&igrave; tiết kiệm hơn.</p>', 'active', 'd2ABCeBzoR.jpeg', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-15', 'normal'),
(19, 8, 'BMW i8 Roadster - xe mui trần dẫn đường ở Formula E', 'bv-bmw-i8-roadster---xe-mui-tran-dan-duong-o-formula-e-19', '<p>Dịp cuối tuần qua, BMW giới thiệu chiếc xe dẫn đường, l&agrave;m nhiệm vụ đảm bảo an to&agrave;n tại giải đua xe Formula E. Giải đua tương tự giải F1, nhưng to&agrave;n bộ xe đua sử dụng động cơ điện.</p>\r\n\r\n<p>i8 Roadster Safety Car dựa tr&ecirc;n chiếc i8 Roadster ti&ecirc;u chuẩn, nhưng c&oacute; những thay đổi để trở th&agrave;nh chiếc xe dẫn đường chuy&ecirc;n dụng. Ngoại h&igrave;nh c&oacute; một số đặc điểm ấn tượng hơn so với nguy&ecirc;n bản. K&iacute;nh chắn gi&oacute; kiểu d&agrave;nh cho xe đua, trọng t&acirc;m hạ thấp 15 mm.</p>', 'active', '9fbeUKTBpU.png', '2019-05-15 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-10', 'normal'),
(20, 6, 'Tia cực tím tại Hà Nội ở mức \'nguy hiểm\'', 'bv-tia-cuc-tim-tai-ha-noi-o-muc-nguy-hiem-20', '<p>Chỉ số tia UV tại H&agrave; Nội ng&agrave;y 18-19/5 l&ecirc;n tới 11, mức được đ&aacute;nh gi&aacute; l&agrave; &quot;nguy hiểm&quot; dễ khiến da, mắt bị bỏng nhiệt.</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/article/tia-cuc-tim-hanoi.png\" style=\"height:171px; width:674px\" /></p>\r\n\r\n<p>H&agrave; Nội đang trải qua đợt nắng n&oacute;ng gay gắt. Theo Trung t&acirc;m Dự b&aacute;o Kh&iacute; tượng Thủy văn Quốc gia, nhiệt độ cao nhất ở H&agrave; Nội ng&agrave;y 18/5 dao động trong khoảng 37 đến 39 độ C, c&oacute; nơi tr&ecirc;n 39 độ.&nbsp;Trang&nbsp;<em>World Weather Online</em>&nbsp;của Anh dự b&aacute;o chỉ số tia cực t&iacute;m tại H&agrave; Nội hai ng&agrave;y 18-19/5 đạt mức 11.&nbsp;</p>', 'active', 'C4DtP4ico8.png', '2019-05-17 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-16', 'normal'),
(21, 3, 'Blockchain và trí tuệ nhân tạo AI làm thay đổi giáo dục trực tuyến', 'bv-blockchain-va-tri-tue-nhan-tao-ai-lam-thay-doi-giao-duc-truc-tuyen-21', '<p>Blockchain khiến dữ liệu trở n&ecirc;n c&ocirc;ng khai, minh bạch với người học, AI gi&uacute;p cải thiện khả năng tương t&aacute;c v&agrave; giảng dạy với từng c&aacute; nh&acirc;n.</p>\r\n\r\n<p>Sự b&ugrave;ng nổ của Internet v&agrave; những c&ocirc;ng nghệ mới như chuỗi khối (Blockchain) v&agrave; tr&iacute; tuệ nh&acirc;n tạo (AI) đ&atilde; g&oacute;p phần l&agrave;m thay đổi nền gi&aacute;o dục tr&ecirc;n to&agrave;n thế giới, h&igrave;nh th&agrave;nh những nền tảng Online Learning với nhiều ưu thế.</p>\r\n\r\n<p><strong>Mobile Learning dự b&aacute;o l&agrave; &quot;Cuộc c&aacute;ch mạng tiếp theo&quot; của gi&aacute;o dục trực tuyến</strong></p>\r\n\r\n<p>Theo nghi&ecirc;n cứu của Global Market Insights, thị trường gi&aacute;o dục trực tuyến to&agrave;n cầu đang c&oacute; tốc độ ph&aacute;t triển nhanh chưa từng thấy khi nền tảng hạ tầng Internet ng&agrave;y c&agrave;ng ho&agrave;n thiện v&agrave; phủ s&oacute;ng rộng khắp. Gi&aacute; trị c&aacute;c start-up về EdTech (C&ocirc;ng ty c&ocirc;ng nghệ chuy&ecirc;n về gi&aacute;o dục) to&agrave;n cầu được ước t&iacute;nh hơn 190 tỷ USD v&agrave;o năm 2018 v&agrave; dự kiến vượt hơn 300 tỷ USD v&agrave;o năm 2025.</p>', 'active', 'Im5BdAHqV1.png', '2019-05-17 00:00:00', 'hailan', '2024-09-16 00:00:00', 'admin', '2019-05-16', 'normal'),
(22, 6, 'Huawei nói lệnh cấm sẽ khiến Mỹ tụt hậu về 5G', 'bv-huawei-noi-lenh-cam-se-khien-my-tut-hau-ve-5g-22', '<p>Huawei khẳng định sắc lệnh mới của Mỹ sẽ chỉ c&agrave;ng khiến qu&aacute; tr&igrave;nh triển khai c&ocirc;ng nghệ 5G ở nước n&agrave;y th&ecirc;m chậm chạp v&agrave; đắt đỏ.</p>\r\n\r\n<p>H&atilde;ng c&ocirc;ng nghệ Trung Quốc tự nhận l&agrave; &quot;người dẫn đầu kh&ocirc;ng ai s&aacute;nh kịp về c&ocirc;ng nghệ 5G&quot;, n&ecirc;n việc bị hạn chế kinh doanh ở Mỹ chỉ dẫn đến kết cục l&agrave; Mỹ sẽ bị &quot;tụt lại ph&iacute;a sau&quot; trong việc triển khai c&ocirc;ng nghệ kết nối di động thế hệ mới</p>', 'active', 'nt1QxhKUXM.jpeg', '2019-05-17 00:00:00', 'hailan', '2024-08-29 00:00:00', 'admin', '2019-05-16', 'normal'),
(23, 7, 'Asus ra mắt Zenfone 6 với camera lật tự động', 'bv-asus-ra-mat-zenfone-6-voi-camera-lat-tu-dong-23', '<p>Với thiết kế m&agrave;n h&igrave;nh tr&agrave;n viền ho&agrave;n to&agrave;n kh&ocirc;ng tai thỏ, camera ch&iacute;nh 48 megapixel tr&ecirc;n Zenfone 6 c&oacute; thể lật từ sau ra trước biến th&agrave;nh camera selfie.</p>\r\n\r\n<p>Zenfone 6 l&agrave; một trong những smartphone c&oacute; viền m&agrave;n h&igrave;nh mỏng nhất tr&ecirc;n thị trường với tỷ lệ m&agrave;n h&igrave;nh hiển thị chiếm tới 92% diện t&iacute;ch mặt trước. M&aacute;y c&oacute; m&agrave;n h&igrave;nh 6,4 inch tr&agrave;n viền ra cả bốn cạnh, kh&ocirc;ng tai thỏ như một số mẫu Zenfone trước v&agrave; cũng kh&ocirc;ng d&ugrave;ng thiết kế đục lỗ như Galaxy S10, S10+...</p>', 'active', 'aiC6j6fWZY.png', '2019-05-17 00:00:00', 'hailan', '2024-10-26 00:00:00', 'admin', '2019-05-16', 'normal'),
(34, 7, 'trí tuệ nhân tạo AI', 'bv-tri-tue-nhan-tao-ai-34', '<p>Trong thời đại m&agrave; tiến bộ c&ocirc;ng nghệ kh&ocirc;ng chỉ l&agrave; một lựa chọn m&agrave; c&ograve;n l&agrave; điều cần thiết, c&aacute;c doanh nghiệp đang ng&agrave;y c&agrave;ng chuyển sang sử dụng Tr&iacute; tuệ nh&acirc;n tạo (AI) để hợp l&yacute; h&oacute;a hoạt động, n&acirc;ng cao hiệu quả v&agrave; đạt được hiệu quả hoạt động xuất sắc. Việc t&iacute;ch hợp AI trong khu&ocirc;n khổ Vận h&agrave;nh xuất sắc (Operational Excellence) hay Lean Six Sigma kh&ocirc;ng chỉ c&oacute; thể tối ưu h&oacute;a hoạt động, quy tr&igrave;nh v&agrave; hệ thống của c&ocirc;ng ty m&agrave; c&ograve;n đ&oacute;ng g&oacute;p đ&aacute;ng kể v&agrave;o văn h&oacute;a cải tiến li&ecirc;n tục v&agrave; tạo ra gi&aacute; trị.&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/article/tri-tue-nhan-tao-ai-la-gi-ung-dung-nhu-the-nao-trong-cuoc-song--6.jpg\" style=\"height:354px; width:630px\" /></p>\r\n\r\n<p>B&agrave;i viết n&agrave;y t&igrave;m hiểu c&aacute;c c&acirc;u hỏi &#39;tại sao&#39;, &#39;c&aacute;i g&igrave;&#39;, &#39;như thế n&agrave;o&#39; v&agrave; &#39;điều g&igrave; sẽ xảy ra tiếp theo&#39; khi &aacute;p dụng AI trong kinh doanh, n&ecirc;u bật cả những cơ hội v&agrave; th&aacute;ch thức m&agrave; n&oacute; mang lại.</p>', 'active', 'cC2FlDJ7S3.jpg', '2024-08-23 00:00:00', 'admin', '2025-04-18 00:00:00', 'admin', NULL, 'normal'),
(42, 4, 'Lợi ích của việc làm \"con Sen\"', 'bv-loi-ich-cua-viec-lam-con-sen-42', '<p>M&egrave;o ch&iacute;nh l&agrave; người bạn l&yacute; tưởng để gi&uacute;p họ kh&ocirc;ng c&ograve;n cảm gi&aacute;c c&ocirc; đơn. Sự hiện diện của m&egrave;o trong cuộc sống hằng ng&agrave;y khiến bạn giảm cảm gi&aacute;c bị c&ocirc; lập, tăng cảm gi&aacute;c hạnh ph&uacute;c. Đặc biệt khi &acirc;u yếm con m&egrave;o, chơi c&ugrave;ng ch&uacute;ng th&igrave; c&oacute; thể&nbsp;<strong>điều chỉnh nhịp tim, giảm mức cholesterol từ đ&oacute; gi&uacute;p giảm khả năng mắc bệnh tim</strong>.</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/cho be choi voi meo cung.jpg\" style=\"height:342px; width:512px\" /></p>\r\n\r\n<h3>Người bạn của người sống độc th&acirc;n</h3>\r\n\r\n<p>Phần lớn cuộc sống hiện nay c&oacute; nhiều người chọn sống độc th&acirc;n. M&egrave;o ch&iacute;nh l&agrave; người bạn l&yacute; tưởng để gi&uacute;p họ kh&ocirc;ng c&ograve;n cảm gi&aacute;c c&ocirc; đơn. Sự hiện diện của m&egrave;o trong cuộc sống hằng ng&agrave;y khiến bạn giảm cảm gi&aacute;c bị c&ocirc; lập, tăng cảm gi&aacute;c hạnh ph&uacute;c. Đặc biệt khi &acirc;u yếm con m&egrave;o, chơi c&ugrave;ng ch&uacute;ng th&igrave; c&oacute; thể điều chỉnh nhịp tim, giảm mức cholesterol từ đ&oacute; gi&uacute;p giảm khả năng mắc&nbsp;bệnh tim.</p>\r\n\r\n<h3>Chữa bệnh, l&agrave;m dịu t&acirc;m hồn</h3>\r\n\r\n<p>Tiếng k&ecirc;u gừ gừ của m&egrave;o l&uacute;c ch&uacute;ng thoải m&aacute;i c&oacute; thể gi&uacute;p giảm căng thẳng cho người nu&ocirc;i m&egrave;o. Đặc biệt tiếng k&ecirc;u đặc trưng n&agrave;y gi&uacute;p l&agrave;m dịu thần kinh, l&agrave;m giảm c&aacute;c hormone g&acirc;y căng thẳng như&nbsp;cortisol, hạ huyết &aacute;p. Chưa kể tiếng k&ecirc;u n&agrave;y của m&egrave;o c&oacute; thể t&aacute;c động t&iacute;ch cực đến tr&iacute; nhớ, tần số k&ecirc;u của m&egrave;o tương ứng với tần số rung của điện c&oacute; thể đưa v&agrave;o điều trị bệnh về xương.</p>\r\n\r\n<h3>Cải thiện chất lượng giấc ngủ, tăng cường hệ miễn dịch</h3>\r\n\r\n<p>M&egrave;o mang lại năng lượng rất l&agrave;nh t&iacute;nh, bản chất của ch&uacute;ng l&agrave; lo&agrave;i vật dịu d&agrave;ng, độc lập. Thường xuy&ecirc;n tiếp x&uacute;c với m&egrave;o c&oacute; thể giảm bớt c&aacute;c triệu chứng g&acirc;y rối loạn giấc ngủ. Chưa kể m&egrave;o rất th&iacute;ch ngủ với người, &ocirc;m ch&uacute;ng ngủ c&ugrave;ng tiếng k&ecirc;u gừ gừ đặc trưng khi m&egrave;o chui r&uacute;c v&agrave;o ngực của bạn sẽ th&uacute;c đẩy bạn ch&igrave;m nhanh v&agrave;o giấc ngủ. B&ecirc;n cạnh đ&oacute;&nbsp;<a href=\"https://nhathuoclongchau.com.vn/bai-viet/long-meo-co-hai-khong-mot-so-cach-giup-lam-giam-tac-hai-cua-long-meo.html\">l&ocirc;ng m&egrave;o</a>, nước bọt, vi tr&ugrave;ng kh&aacute;c gi&uacute;p r&egrave;n luyện cho hệ thống miễn dịch của con người, l&agrave;m cho ch&uacute;ng ta x&acirc;y dựng được hệ thống ph&ograve;ng mầm bệnh c&ugrave;ng c&aacute;c chất g&acirc;y dị ứng.</p>', 'active', 'JieTnUD6Un.jpg', '2025-04-17 00:00:00', 'admin', '2025-08-03 00:00:00', 'admin', NULL, 'feature');

--
-- Bẫy `article`
--
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterDeleteArticle` AFTER DELETE ON `article` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount - 1
  WHERE `TableName` = 'article';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterUpdateArticle` AFTER UPDATE ON `article` FOR EACH ROW BEGIN
  -- Assuming that the primary key of the article table is 'id'
  IF NEW.id <> OLD.id THEN
    UPDATE `totalelements`
    SET ElementCount = ElementCount + 1
    WHERE `TableName` = 'article';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsArticle` AFTER INSERT ON `article` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount + 1
  WHERE `TableName` = 'article';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article_translations`
--

CREATE TABLE `article_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `article_translations`
--

INSERT INTO `article_translations` (`id`, `article_id`, `locale`, `name`, `slug`, `content`) VALUES
(1, 6, 'en', 'Cardiff coach: \'Man Utd will not win the championship in the next 10 years\'', 'bv-Cardiff-coach-man-utd-will-not-win-the-championship-in-the-next-10-years-6', '<p>Neil Warnock questions Man Utd\'s future under Solskjaer.\r\n\r\n\"Some people think Man Utd need two or three more transfer windows to win a title,\" coach Neil Warnock shared. \"I think it could take 10 years. I don\'t see them catching up with the top two clubs in the next four or five years.\"\r\n\r\nThe last time Man Utd won the title was in the 2012-2013 season under Sir Alex Ferguson. Since then, the \"Red Devils\" have failed to maintain their status as a top title contender.</p>'),
(2, 6, 'vi', 'HLV Cardiff: \'Man Utd sẽ không vô địch trong 10 năm tới\'', 'bv-hlv-cardiff-man-utd-se-khong-vo-dich-trong-10-nam-toi-6', '<p>Neil Warnock tỏ ra nghi ngờ về tương lai của Man Utd dưới thời HLV Solskjaer.</p>\r\n\r\n<p>&quot;Một số người nghĩ Man Utd cần từ hai đến ba kỳ chuyển nhượng nữa để gi&agrave;nh danh hiệu&quot;, HLV Neil Warnock chia sẻ. &quot;T&ocirc;i th&igrave; nghĩ c&oacute; thể l&agrave; 10 năm. T&ocirc;i kh&ocirc;ng thấy học&oacute; khả năng bắt kịp hai CLB h&agrave;ng đầu trong khoảng bốn hay năm năm tới&quot;.</p>\r\n\r\n<p>Lần cuối Man Utd v&ocirc; địch l&agrave; m&ugrave;a 2012-2013 dưới thời HLV Sir Alex Ferguson. Kể từ đ&oacute; đến nay, &quot;Quỷ đỏ&quot; kh&ocirc;ng c&ograve;n duy tr&igrave; được vị thế ứng cử vi&ecirc;n v&ocirc; địch h&agrave;ng đầu.&nbsp;</p>'),
(3, 4, 'vi', 'Liverpool chỉ được nâng Cup phiên bản nếu vô địch hôm nay', 'bv-liverpool-chi-duoc-nang-cup-phien-ban-neu-vo-dich-hom-nay-4', '<p>Đội b&oacute;ng th&agrave;nh phố cảng sẽ kh&ocirc;ng n&acirc;ng Cup nguy&ecirc;n bản nếu vượt mặt Man City ở v&ograve;ng cuối Ngoại hạng Anh.</p>\r\n\r\n<p>Liverpool k&eacute;m Man City một điểm trước khi tiếp Wolverhampton tr&ecirc;n s&acirc;n nh&agrave; Anfield v&agrave;o ng&agrave;y Chủ Nhật. Ở trận đấu c&ugrave;ng giờ, Man City sẽ l&agrave;m kh&aacute;ch tới s&acirc;n Brighton v&agrave; biết một chiến thắng sẽ gi&uacute;p họ bảo vệ th&agrave;nh c&ocirc;ng ng&ocirc;i v&ocirc; địch. Kể từ khi c&aacute;c trận v&ograve;ng cuối Ngoại hạng Anh sẽ chơi đồng loạt c&ugrave;ng l&uacute;c, ban tổ chức phải đặt một chiếc cup phi&ecirc;n bản giống thật tại Anfield ph&ograve;ng trường hợp Liverpool v&ocirc; địch. Chiếc cup giả n&agrave;y thường được d&ugrave;ng trong c&aacute;c sự kiện quảng b&aacute; của Ngoại hạng Anh.&nbsp;</p>'),
(4, 4, 'en', 'Liverpool will only lift the replica trophy if they win today', 'bv-Liverpool-will-only-lift-the-replica-trophy-if-they-win-today-4', '<p>The port city club will not lift the original trophy if they overtake Man City on the final day of the Premier League.\r\n\r\nLiverpool trail Man City by one point before hosting Wolverhampton at Anfield on Sunday. At the same time, Man City will visit Brighton, knowing that a win will secure their title defense. Since all final-round Premier League matches are played simultaneously, the organizers have placed a replica trophy at Anfield in case Liverpool wins the title. This replica trophy is usually used for Premier League promotional events.</p>'),
(7, 16, 'vi', 'Những câu đố giúp rèn luyện trí não', 'bv-nhung-cau-do-giup-ren-luyen-tri-nao-16', '<p>Bạn cần quan s&aacute;t, suy luận logic v&agrave; c&oacute; vốn từ vựng tiếng Anh để giải quyết những c&acirc;u đố dưới đ&acirc;y.</p>\r\n      \r\n      <p>C&acirc;u 1:&nbsp;Mike đến một buổi phỏng vấn xin việc. Anh đ&atilde; g&acirc;y ấn tượng với gi&aacute;m đốc về những kỹ năng v&agrave; kinh nghiệm của m&igrave;nh. Tuy nhi&ecirc;n, để quyết định c&oacute; nhận Mike hay kh&ocirc;ng, nữ gi&aacute;m đốc đưa ra một c&acirc;u đố h&oacute;c b&uacute;a v&agrave; y&ecirc;u cầu Mike trả lời trong 30 gi&acirc;y.</p> ◀\r\n      \r\n      <p>Nội dung c&acirc;u đố: H&atilde;y đưa ra 30 từ tiếng Anh kh&ocirc;ng c&oacute; chữ &quot;a&quot; xuất hiện trong đ&oacute;?&nbsp;</p>\r\n      \r\n      <p>Mike dễ d&agrave;ng giải quyết c&acirc;u đố. Theo bạn anh ấy n&oacute;i những từ tiếng Anh n&agrave;o để kịp trả lời trong 30 gi&acirc;y?</p>'),
(8, 16, 'en', 'Brain-Training Riddles', 'bv-brain-training-riddles-16', '<p>You need keen observation, logical reasoning, and a good English vocabulary to solve the following puzzles.\r\nPuzzle 1:\r\nMike attends a job interview. He impresses the director with his skills and experience. However, to decide whether to hire Mike, the female director presents him with a tricky riddle and gives him 30 seconds to answer.\r\n\r\nThe riddle: \"Name 30 English words that do not contain the letter \'a\'.\"\r\n\r\nMike easily solves the puzzle. What words do you think he said to answer within 30 seconds?</p>'),
(9, 15, 'en', 'Man City Still Eligible for the 2019-2020 Champions League', 'bv-man-city-still-eligible-for-the-2019-2020-champions-league-15', '<p>The investigation into Etihad Stadium\'s financial fair play violations will not be concluded within the next year.\r\n\r\nAccording to Sports Mail (UK), the one-season Champions League ban for Man City, due to violations of Financial Fair Play (FFP) rules, would only take effect at the earliest in the 2020-2021 season.\r\n\r\nIn an open letter to the British media, Man City stated: \"We are cooperating in good faith with UEFA\'s Club Financial Control Body (CFCB). The club trusts in CFCB\'s independence and its commitment, as stated on March 7, that no conclusions will be drawn during the investigation period.\"</p>'),
(10, 15, 'vi', 'Man City vẫn dự Champions League mùa 2019-2020', 'bv-man-city-van-du-champions-league-mua-2019-2020-15', '<p>Việc điều tra vi phạm luật c&ocirc;ng bằng t&agrave;i ch&iacute;nh của chủ s&acirc;n Etihad chưa thể ho&agrave;n th&agrave;nh trong v&ograve;ng một năm tới.</p>\r\n\r\n<p><em>Sports Mail</em>&nbsp;(Anh)&nbsp;cho biết, &aacute;n phạt cấm tham dự Champions League một m&ugrave;a với Man City, do vi phạm luật c&ocirc;ng bằng t&agrave;i ch&iacute;nh (FFP), chỉ được đưa ra sớm nhất v&agrave;o m&ugrave;a 2020-2021.</p>\r\n\r\n<p>Trong bức thư ngỏ gửi tới truyền th&ocirc;ng Anh, Man City viết: &quot;Ch&uacute;ng t&ocirc;i hợp t&aacute;c một c&aacute;ch thiện ch&iacute; với Tiểu ban kiểm so&aacute;t t&agrave;i ch&iacute;nh c&aacute;c CLB của UEFA (CFCB). CLB tin tưởng v&agrave;o sự độc lập v&agrave; cam kết của CFCB h&ocirc;m 7/3, rằng sẽ kh&ocirc;ng kết luận g&igrave; trong thời gian điều tra&quot;.</p>'),
(11, 14, 'en', 'Hanoi Advances to AFC Cup Knockout Stage', 'bv-hanoi-advances-to-aFC-cup-knockout-stage-14', '<p>The V-League defending champions defeated Tampines Rovers 2-0 on May 15 to top Group F.\r\n\r\nFacing the Singaporean opponents in a must-win match to secure their own fate, Hanoi had an easy game. The outcome was essentially decided in the first half when Oseni and Thành Chung scored for the home team. Meanwhile, Tampines Rovers paid the price for their rough play as Yasir Hanapi received a second yellow card and was sent off. The midfielder was punished for an off-the-ball foul on Thành Chung early in the game, followed by a reckless challenge on Đình Trọng.</p>'),
(12, 14, 'vi', 'Hà Nội vào vòng knock-out AFC Cup', 'bv-ha-noi-vao-vong-knock-out-afc-cup-14', '<p>ĐKVĐ V-League đánh bại Tampines Rovers 2-0 vào chiều 15/5 để đứng đầu bảng F.\r\n\r\nTiếp đối thủ đến từ Singapore trong tình thế buộc phải thắng để tự quyết vé đi tiếp, Hà Nội đã có trận đấu dễ dàng. Có thể nói, kết quả của trận đấu được định đoạt trong hiệp một khi Oseni và Thành Chung lần lượt ghi bàn cho đội chủ nhà. Trong khi đó, Tampines Rovers phải trả giá cho lối chơi thô bạo khi Yasir Hanapi nhận thẻ vàng thứ hai rời sân. Tiền vệ này bị trừng phạt bởi pha đánh nguội với Thành Chung ở đầu trận, sau đó là tình huống phạm lỗi ác ý với Đình Trọng.</p>'),
(16, 42, 'vi', 'Lợi ích của việc làm \"con Sen\"', 'bv-loi-ich-cua-viec-lam-con-sen-42', '<p>M&egrave;o ch&iacute;nh l&agrave; người bạn l&yacute; tưởng để gi&uacute;p họ kh&ocirc;ng c&ograve;n cảm gi&aacute;c c&ocirc; đơn. Sự hiện diện của m&egrave;o trong cuộc sống hằng ng&agrave;y khiến bạn giảm cảm gi&aacute;c bị c&ocirc; lập, tăng cảm gi&aacute;c hạnh ph&uacute;c. Đặc biệt khi &acirc;u yếm con m&egrave;o, chơi c&ugrave;ng ch&uacute;ng th&igrave; c&oacute; thể&nbsp;<strong>điều chỉnh nhịp tim, giảm mức cholesterol từ đ&oacute; gi&uacute;p giảm khả năng mắc bệnh tim</strong>.</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/cho be choi voi meo cung.jpg\" style=\"height:342px; width:512px\" /></p>\r\n\r\n<h3>Người bạn của người sống độc th&acirc;n</h3>\r\n\r\n<p>Phần lớn cuộc sống hiện nay c&oacute; nhiều người chọn sống độc th&acirc;n. M&egrave;o ch&iacute;nh l&agrave; người bạn l&yacute; tưởng để gi&uacute;p họ kh&ocirc;ng c&ograve;n cảm gi&aacute;c c&ocirc; đơn. Sự hiện diện của m&egrave;o trong cuộc sống hằng ng&agrave;y khiến bạn giảm cảm gi&aacute;c bị c&ocirc; lập, tăng cảm gi&aacute;c hạnh ph&uacute;c. Đặc biệt khi &acirc;u yếm con m&egrave;o, chơi c&ugrave;ng ch&uacute;ng th&igrave; c&oacute; thể điều chỉnh nhịp tim, giảm mức cholesterol từ đ&oacute; gi&uacute;p giảm khả năng mắc&nbsp;bệnh tim.</p>\r\n\r\n<h3>Chữa bệnh, l&agrave;m dịu t&acirc;m hồn</h3>\r\n\r\n<p>Tiếng k&ecirc;u gừ gừ của m&egrave;o l&uacute;c ch&uacute;ng thoải m&aacute;i c&oacute; thể gi&uacute;p giảm căng thẳng cho người nu&ocirc;i m&egrave;o. Đặc biệt tiếng k&ecirc;u đặc trưng n&agrave;y gi&uacute;p l&agrave;m dịu thần kinh, l&agrave;m giảm c&aacute;c hormone g&acirc;y căng thẳng như&nbsp;cortisol, hạ huyết &aacute;p. Chưa kể tiếng k&ecirc;u n&agrave;y của m&egrave;o c&oacute; thể t&aacute;c động t&iacute;ch cực đến tr&iacute; nhớ, tần số k&ecirc;u của m&egrave;o tương ứng với tần số rung của điện c&oacute; thể đưa v&agrave;o điều trị bệnh về xương.</p>\r\n\r\n<h3>Cải thiện chất lượng giấc ngủ, tăng cường hệ miễn dịch</h3>\r\n\r\n<p>M&egrave;o mang lại năng lượng rất l&agrave;nh t&iacute;nh, bản chất của ch&uacute;ng l&agrave; lo&agrave;i vật dịu d&agrave;ng, độc lập. Thường xuy&ecirc;n tiếp x&uacute;c với m&egrave;o c&oacute; thể giảm bớt c&aacute;c triệu chứng g&acirc;y rối loạn giấc ngủ. Chưa kể m&egrave;o rất th&iacute;ch ngủ với người, &ocirc;m ch&uacute;ng ngủ c&ugrave;ng tiếng k&ecirc;u gừ gừ đặc trưng khi m&egrave;o chui r&uacute;c v&agrave;o ngực của bạn sẽ th&uacute;c đẩy bạn ch&igrave;m nhanh v&agrave;o giấc ngủ. B&ecirc;n cạnh đ&oacute;&nbsp;<a href=\"https://nhathuoclongchau.com.vn/bai-viet/long-meo-co-hai-khong-mot-so-cach-giup-lam-giam-tac-hai-cua-long-meo.html\">l&ocirc;ng m&egrave;o</a>, nước bọt, vi tr&ugrave;ng kh&aacute;c gi&uacute;p r&egrave;n luyện cho hệ thống miễn dịch của con người, l&agrave;m cho ch&uacute;ng ta x&acirc;y dựng được hệ thống ph&ograve;ng mầm bệnh c&ugrave;ng c&aacute;c chất g&acirc;y dị ứng.</p>'),
(17, 42, 'en', 'Benefits of playing with Boss Cat', 'bv-benefits-of-playing-with-boss-cat-42', '<p>Cats are the ideal companions to help them no longer feel lonely. The presence of cats in daily life makes you less isolated, increases happiness. Especially when cuddling cats, playing with them can regulate heart rate, reduce cholesterol levels, thereby helping to reduce the possibility of heart disease.</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/be thich choi voi meo.jpg\" style=\"height:342px; width:512px\" /></p>\r\n\r\n<p>Cure, soothe the soul<br />\r\nThe purr of a cat when they are comfortable can help reduce stress for cat owners. In particular, this characteristic cry helps calm the nerves, reduce stress hormones such as cortisol, lower blood pressure. Not to mention that this cat&#39;s cry can have a positive impact on memory, the frequency of the cat&#39;s cry corresponds to the frequency of electric vibrations that can be used to treat bone diseases.</p>\r\n\r\n<p>Improve sleep quality, strengthen the immune system<br />\r\nCats bring very benign energy, their nature is gentle, independent animals. Frequent contact with cats can reduce symptoms of sleep disorders. Not to mention that cats love to sleep with people, hugging them to sleep with the characteristic purr when the cat nestles on your chest will promote you to fall asleep quickly. In addition, cat hair, saliva, and other germs help train the human immune system, allowing us to build a system to prevent pathogens and allergens.</p>'),
(18, 34, 'en', 'artificial intelligence', 'bv-artificial-intelligence-34', '<p>In an era where technological advancement is not only an option but a necessity, businesses are increasingly turning to Artificial Intelligence (AI) to streamline operations, improve efficiency and achieve operational excellence. Integrating AI within an Operational Excellence or Lean Six Sigma framework can not only optimize a company&rsquo;s operations, processes and systems but also contribute significantly to a culture of continuous improvement and value creation.</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/ai.jfif\" style=\"height:168px; width:300px\" /></p>'),
(19, 34, 'vi', 'trí tuệ nhân tạo AI', 'bv-tri-tue-nhan-tao-ai-34', '<p>Trong thời đại m&agrave; tiến bộ c&ocirc;ng nghệ kh&ocirc;ng chỉ l&agrave; một lựa chọn m&agrave; c&ograve;n l&agrave; điều cần thiết, c&aacute;c doanh nghiệp đang ng&agrave;y c&agrave;ng chuyển sang sử dụng Tr&iacute; tuệ nh&acirc;n tạo (AI) để hợp l&yacute; h&oacute;a hoạt động, n&acirc;ng cao hiệu quả v&agrave; đạt được hiệu quả hoạt động xuất sắc. Việc t&iacute;ch hợp AI trong khu&ocirc;n khổ Vận h&agrave;nh xuất sắc (Operational Excellence) hay Lean Six Sigma kh&ocirc;ng chỉ c&oacute; thể tối ưu h&oacute;a hoạt động, quy tr&igrave;nh v&agrave; hệ thống của c&ocirc;ng ty m&agrave; c&ograve;n đ&oacute;ng g&oacute;p đ&aacute;ng kể v&agrave;o văn h&oacute;a cải tiến li&ecirc;n tục v&agrave; tạo ra gi&aacute; trị.&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"http://proj_news.xyz/images/article/tri-tue-nhan-tao-ai-la-gi-ung-dung-nhu-the-nao-trong-cuoc-song--6.jpg\" style=\"height:354px; width:630px\" /></p>\r\n\r\n<p>B&agrave;i viết n&agrave;y t&igrave;m hiểu c&aacute;c c&acirc;u hỏi &#39;tại sao&#39;, &#39;c&aacute;i g&igrave;&#39;, &#39;như thế n&agrave;o&#39; v&agrave; &#39;điều g&igrave; sẽ xảy ra tiếp theo&#39; khi &aacute;p dụng AI trong kinh doanh, n&ecirc;u bật cả những cơ hội v&agrave; th&aacute;ch thức m&agrave; n&oacute; mang lại.</p>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `article_views`
--

CREATE TABLE `article_views` (
  `id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `article_views`
--

INSERT INTO `article_views` (`id`, `article_id`, `views`, `created`, `status`, `modified`) VALUES
(1, 23, 5, '2024-02-29 00:00:00', 'active', '2024-02-29 13:46:40'),
(2, 16, 6, '2024-03-12 00:00:00', 'active', '2024-03-12 09:05:57'),
(3, 15, 6, '2024-03-25 00:00:00', 'active', '2024-03-25 14:44:49'),
(4, 21, 6, '2024-06-17 00:00:00', 'active', '2024-06-17 23:55:11'),
(5, 22, 4, '2024-06-17 00:00:00', 'active', '2024-06-17 23:56:14'),
(6, 4, 3, '2024-09-17 00:00:00', 'active', '2024-09-18 04:27:19'),
(7, 35, 1, '2024-10-16 00:00:00', 'active', '2024-10-16 13:48:04'),
(8, 34, 6, '2024-10-16 00:00:00', 'active', '2024-10-16 13:55:55'),
(9, 20, 6, '2024-10-21 00:00:00', 'active', '2024-10-21 08:46:15'),
(10, 18, 3, '2024-10-21 00:00:00', 'active', '2024-10-21 08:51:07'),
(11, 14, 2, '2024-10-21 00:00:00', 'active', '2024-10-21 08:55:23'),
(12, 11, 1, '2024-10-21 00:00:00', 'active', '2024-10-21 08:59:21'),
(13, 7, 2, '2024-10-21 00:00:00', 'active', '2024-10-21 09:05:09'),
(14, 6, 3, '2024-10-21 00:00:00', 'active', '2024-10-21 09:05:59'),
(15, 3, 1, '2024-10-21 00:00:00', 'active', '2024-10-21 09:06:06'),
(16, 5, 2, '2024-10-21 00:00:00', 'active', '2024-10-21 09:06:12'),
(17, 42, 2, '2025-07-08 00:00:00', 'active', '2025-07-08 09:01:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(225) DEFAULT NULL,
  `fieldClass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `status`, `fieldClass`) VALUES
(1, 'color', 'active', 'màu sắc'),
(2, 'material', 'active', 'dung lượng'),
(3, 'slogan', 'active', 'khẩu hiệu');

--
-- Bẫy `attribute`
--
DELIMITER $$
CREATE TRIGGER `before_attribute_delete` BEFORE DELETE ON `attribute` FOR EACH ROW DELETE FROM attribute_value
  WHERE attribute_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attribute_value`
--

CREATE TABLE `attribute_value` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `fieldClass` varchar(255) DEFAULT NULL,
  `status` varchar(225) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(225) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(225) DEFAULT NULL,
  `ordering` int(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attribute_value`
--

INSERT INTO `attribute_value` (`id`, `attribute_id`, `name`, `color`, `fieldClass`, `status`, `created`, `created_by`, `modified`, `modified_by`, `ordering`) VALUES
(1, 1, 'vàng', '#d5ff05', NULL, 'active', NULL, NULL, '2025-06-25 00:00:00', 'admin', 1),
(2, 1, 'đỏ', '#ff0000', NULL, 'active', NULL, NULL, '2025-06-25 00:00:00', 'admin', 2),
(3, 1, 'xanh dương', '#0011ff', NULL, 'active', NULL, NULL, '2025-06-25 00:00:00', 'admin', 3),
(4, 1, 'đen', '#0d0c0c', NULL, 'active', '2025-06-13 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 4),
(5, 1, 'trắng/bạc', '#ffffff', NULL, 'active', '2025-06-13 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 5),
(6, 1, 'xám', '#b6b4b4', NULL, 'active', '2025-06-13 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 6),
(7, 1, 'xanh lục', '#2bff00', NULL, 'active', '2025-06-25 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 7),
(56, 2, '128 GB', NULL, NULL, 'active', '2024-12-23 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 50),
(57, 2, '256 GB', NULL, NULL, 'active', '2024-12-23 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 51),
(58, 2, '512 GB', NULL, NULL, 'active', '2024-12-23 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 52),
(59, 3, 'zenvn', NULL, NULL, 'active', '2024-12-23 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 70),
(60, 3, 'Laravel', NULL, NULL, 'active', '2024-12-23 00:00:00', 'admin', '2025-06-25 00:00:00', 'admin', 71),
(65, 1, 'titan tự nhiên', '#e6e6e6', NULL, 'active', '2025-06-25 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 9),
(66, 1, 'titan sa mạc', '#ddb55f', NULL, 'active', '2025-06-25 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 12),
(67, 1, 'titan đen', '#474747', NULL, 'active', '2025-06-25 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 13),
(68, 1, 'tím', '#f505e1', NULL, 'active', '2025-08-06 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 10),
(69, 2, '1 Tb', NULL, NULL, 'active', '2025-08-06 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 52),
(70, 1, 'cam', '#ff9500', NULL, 'active', '2025-08-06 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 11),
(71, 1, 'hồng', '#ee87ab', NULL, 'active', '2025-08-06 00:00:00', 'admin', '2025-08-06 00:00:00', 'admin', 14);

--
-- Bẫy `attribute_value`
--
DELIMITER $$
CREATE TRIGGER `before_attribute_value_delete` BEFORE DELETE ON `attribute_value` FOR EACH ROW DELETE FROM product_has_attribute
  WHERE attribute_value_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `googlemap` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `branch`
--

INSERT INTO `branch` (`id`, `name`, `address`, `googlemap`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Chi nhánh 1 ', 'Tầng 5, Tòa nhà Songdo, 62A Phạm Ngọc Thạch, Phường 6, Quận 3, Hồ Chí Minh', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.360420162197!2d106.73409077043847!3d10.860167434007112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527d5640014e7%3A0x3bb323b29d50dca9!2zWmVuZFZOIC0gxJDDoG8gVOG6oW8gTOG6rXAgVHLDrG5oIFZpw6pu!5e0!3m2!1svi!2s!4v1723180040792!5m2!1svi!2s\" width=\"600\" height=\"500\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'active', '2024-08-03 02:09:49', 'admin', NULL, NULL),
(2, 'Chi nhánh 2', '757C Kha Vạn Cân, P.Linh Tây, Thủ Đức, Hcm', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.394524423644!2d106.75456067408862!3d10.857567757693781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752790c6385033%3A0xcea70174e60f1df1!2zNzU3QyDEkC4gS2hhIFbhuqFuIEPDom4sIEtodSBQaOG7kSAzLCBUaOG7pyDEkOG7qWMsIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1723180130179!5m2!1svi!2s\" width=\"600\" height=\"500\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'active', '2024-08-03 02:10:01', 'admin', NULL, NULL),
(3, 'Chi nhánh 3', '523 Đỗ Xuân Hợp, Block C chung cư The Art, KDCQ10', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7837.938494461986!2d106.76874347770996!3d10.81366530000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175270f5c87c7f5%3A0x7523fa4ea7f3c8fa!2sChung%20C%C6%B0%20The%20Art!5e0!3m2!1svi!2s!4v1723180243970!5m2!1svi!2s\" width=\"600\" height=\"500\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'active', '2024-08-03 02:10:09', 'admin', '2024-10-26 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branch_translations`
--

CREATE TABLE `branch_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `branch_translations`
--

INSERT INTO `branch_translations` (`id`, `branch_id`, `locale`, `name`, `address`) VALUES
(1, 1, 'vi', 'Chi nhánh 1 ', 'Tầng 5, Tòa nhà Songdo, 62A Phạm Ngọc Thạch, Phường 6, Quận 3, Hồ Chí Minh'),
(2, 1, 'en', 'Branch 1', '5th Floor, Songdo Building, 62A Pham Ngoc Thach, Ward 6, District 3, Ho Chi Minh City'),
(3, 2, 'vi', 'Chi nhánh 2', '757C Kha Vạn Cân, P.Linh Tây, Thủ Đức, Hcm'),
(4, 1, 'en', 'Branch 2', '757C Kha Van Can, Linh Tay Ward, Thu Duc,Ho Chi Minh City'),
(5, 3, 'vi', 'Chi nhánh 3', '523 Đỗ Xuân Hợp, Block C chung cư The Art, KDCQ10, Hồ Chí Minh'),
(6, 1, 'en', 'Branch 3', '523 Do Xuan Hop, Block C The Art Apartment, KDCQ10, Ho Chi Minh city');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_article`
--

CREATE TABLE `category_article` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` text NOT NULL,
  `is_home` tinyint(1) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `_lft` int(11) DEFAULT NULL,
  `_rgt` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `category_article`
--

INSERT INTO `category_article` (`id`, `name`, `slug`, `status`, `is_home`, `display`, `created`, `created_by`, `modified`, `modified_by`, `parent_id`, `_lft`, `_rgt`) VALUES
(1, 'Root', '', 'active', 0, '', NULL, '', NULL, '', NULL, 1, 32),
(2, 'Thể Thao', 'cm-the-thao-2', 'active', 1, 'grid', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 3, 13, 26),
(3, 'Giáo dục', 'cm-giao-duc-3', 'active', 1, 'list', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 1, 12, 27),
(4, 'Sức khỏe', 'cm-suc-khoe-4', 'active', 1, 'grid', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 1, 2, 11),
(5, 'Du lịch', 'cm-du-lich-5', 'active', 0, 'list', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 4, 3, 6),
(6, 'Khoa học', 'cm-khoa-hoc-6', 'active', 1, 'grid', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 4, 7, 8),
(7, 'Số hóa', 'cm-so-hoa-7', 'active', 1, 'grid', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 5, 4, 5),
(8, 'Xe - Ô tô', 'cm-xe-o-to-8', 'active', 1, 'list', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 1, 28, 29),
(9, 'Kinh doanh', 'cm-kinh-doanh-9', 'active', 0, 'grid', '2024-09-10 00:00:00', 'dat123', '2025-04-25 00:00:00', 'admin', 1, 30, 31),
(10, 'Thể thao child001', 'cm-the-thao-child001-10', 'active', 0, 'list', '2024-09-10 00:00:00', 'dat123', '2025-04-24 00:00:00', 'admin', 2, 14, 15),
(18, 'Thể thao child003', 'cm-the-thao-child003-18', 'active', NULL, NULL, '2025-04-23 00:00:00', 'admin', '2025-04-24 00:00:00', 'admin', 2, 22, 23);

--
-- Bẫy `category_article`
--
DELIMITER $$
CREATE TRIGGER `updateTotalElements` AFTER INSERT ON `category_article` FOR EACH ROW BEGIN
  UPDATE totalelements
  SET ElementCount = ElementCount + 1
  WHERE TableName = 'category_article';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterDelete` AFTER DELETE ON `category_article` FOR EACH ROW BEGIN
  UPDATE totalelements
  SET ElementCount = ElementCount - 1
  WHERE TableName = 'category_article';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterUpdate` AFTER UPDATE ON `category_article` FOR EACH ROW BEGIN
  -- Assuming that the primary key of the article table is 'id'
  IF NEW.id <> OLD.id THEN
    UPDATE totalelements
    SET ElementCount = ElementCount + 1
    WHERE TableName = 'category_article';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_article_translations`
--

CREATE TABLE `category_article_translations` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `category_article_id` int(11) DEFAULT NULL,
  `locale` varchar(11) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `category_article_translations`
--

INSERT INTO `category_article_translations` (`id`, `name`, `category_article_id`, `locale`, `slug`) VALUES
(1, 'Thể Thao', 2, 'vi', 'cm-the-thao-2'),
(3, 'Giáo dục', 3, 'vi', 'cm-giao-duc-3'),
(5, 'Sức khỏe', 4, 'vi', 'cm-suc-khoe-4'),
(8, 'Tourism', 5, 'en', 'ca-tourism-5'),
(9, 'Khoa học', 6, 'vi', 'cm-khoa-hoc-6'),
(11, 'Số hóa', 7, 'vi', 'cm-so-hoa-7'),
(13, 'Xe - Ô tô', 8, 'vi', 'cm-xe-o-to-8'),
(15, 'Kinh doanh', 9, 'vi', 'cm-kinh-doanh-9'),
(17, 'Thể thao child001', 10, 'vi', 'cm-the-thao-child001-10'),
(10, 'Science', 6, 'en', 'ca-science-6'),
(2, 'Sport', 2, 'en', 'ca-sport-2'),
(4, 'Education', 3, 'en', 'ca-education-3'),
(6, 'Health', 4, 'en', 'ca-health-4'),
(12, 'Digitalization', 7, 'en', 'ca-digitalization-7'),
(14, 'car', 8, 'en ', 'ca-car-8'),
(16, 'Business', 9, 'en', 'ca-business-9'),
(18, 'Sport child001', 10, 'en', 'ca-sport-child001-10'),
(19, 'Thể thao child003', 18, 'vi', 'cm-the-thao-child003-18'),
(20, 'sport child003', 18, 'en', 'ca-sport-child003-18'),
(23, 'Du lịch', 5, 'vi', 'cm-du-lich-5');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_product`
--

CREATE TABLE `category_product` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` text NOT NULL,
  `is_home` tinyint(1) DEFAULT NULL,
  `display` varchar(255) DEFAULT NULL,
  `is_phone_category` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `_lft` int(11) DEFAULT NULL,
  `_rgt` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `category_product`
--

INSERT INTO `category_product` (`id`, `name`, `slug`, `status`, `is_home`, `display`, `is_phone_category`, `created`, `created_by`, `modified`, `modified_by`, `parent_id`, `_lft`, `_rgt`) VALUES
(1, 'Root', '', 'active', 0, '', NULL, NULL, '', NULL, '', NULL, 1, 20),
(6, 'Điện thoại', 'cm-dien-thoai-6', 'active', 1, 'list', '0', '2024-10-22 00:00:00', 'dat123', '2025-06-07 00:00:00', 'admin', 1, 2, 9),
(3, 'Laptop', 'cm-laptop-3', 'active', 0, NULL, NULL, '2024-10-22 00:00:00', 'dat123', '2025-07-15 00:00:00', 'admin', 4, 11, 12),
(4, 'Máy tính', 'cm-may-tinh--4', 'active', 0, 'grid', NULL, '2024-10-22 00:00:00', 'dat123', '2025-07-15 00:00:00', 'admin', 1, 10, 15),
(5, 'Đồng hồ', 'cm-dong-ho-5', 'inactive', 0, NULL, NULL, '2024-10-22 00:00:00', 'dat123', '2025-07-08 00:00:00', 'admin', 1, 16, 17),
(7, 'Tivi', 'cm-tivi-7', 'inactive', 0, NULL, NULL, '2024-10-29 00:00:00', 'admin', '2025-07-08 00:00:00', 'admin', 1, 18, 19),
(8, 'Iphone', 'cm-iphone-8', 'active', 1, NULL, '1', '2024-10-29 00:00:00', 'admin', '2025-06-07 00:00:00', 'admin', 6, 3, 4),
(9, 'Samsung', 'cm-samsung-9', 'active', 1, NULL, '1', '2024-10-29 00:00:00', 'admin', '2025-06-07 00:00:00', 'admin', 6, 5, 6),
(10, 'decktop', 'cm-decktop-10', 'active', 0, NULL, NULL, '2024-10-29 00:00:00', 'admin', '2025-07-18 00:00:00', 'admin', 4, 13, 14),
(11, 'oppo', 'cm-oppo-11', 'active', 1, NULL, '1', '2025-02-06 00:00:00', 'admin', '2025-06-07 00:00:00', 'admin', 6, 7, 8);

--
-- Bẫy `category_product`
--
DELIMITER $$
CREATE TRIGGER `before_category_product_delete` BEFORE DELETE ON `category_product` FOR EACH ROW DELETE FROM product
  WHERE category_product_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `ip_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `message`, `status`, `time`, `ip_address`) VALUES
(1, 'abc123', 'admin@gmail.com', '123213213', 'dsdad dasdasd đấ dasdas', 'inactive', '2024-08-19 11:10:00', '127.0.0.1'),
(2, 'abc1234', 'admin@gmail.com', '123456789112345', 'dadasda dá đấ dasdas dsadas', 'inactive', '2024-08-19 11:15:00', '127.0.0.1'),
(3, 'test01', 'test@gmail.com', '22345678', 'sadasd dadas dasd asdas', 'inactive', '2024-08-19 12:38:00', '127.0.0.1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `value` int(11) NOT NULL,
  `start_time` datetime NOT NULL DEFAULT current_timestamp(),
  `end_time` datetime NOT NULL DEFAULT current_timestamp(),
  `start_price` int(11) NOT NULL,
  `end_price` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `total_use` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon`
--

INSERT INTO `coupon` (`id`, `code`, `type`, `value`, `start_time`, `end_time`, `start_price`, `end_price`, `total`, `total_use`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, '5KOyp5', 'percent', 10, '2024-12-06 16:12:01', '2024-12-23 08:12:01', 50000, 100000, 10, 0, 'active', '2024-12-07 08:20:01', 'admin', '2024-12-12 00:00:00', 'admin'),
(2, 'tg2CJM', 'percent', 30, '2024-12-02 15:12:00', '2024-12-31 23:12:59', 30000, 50000, 10, 0, 'active', '2024-12-12 00:00:00', 'admin', '2024-12-13 00:00:00', 'admin'),
(3, '2ywu0e', 'price', 10000, '2024-12-03 06:12:00', '2025-01-02 16:01:59', 10000, 50000, 20, 0, 'active', '2024-12-14 00:00:00', 'admin', '2024-12-21 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `total` decimal(12,2) DEFAULT 0.00,
  `price` int(11) DEFAULT NULL,
  `status` enum('processing','packing','shipping','complete') DEFAULT 'processing',
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice`
--

INSERT INTO `invoice` (`id`, `code`, `user_id`, `username`, `created`, `total`, `price`, `status`, `modified`, `modified_by`) VALUES
(18, 'INV-04210102082025-3817', 3, 'user123', '2025-08-02 04:21:01', 1.00, 350, 'packing', '2025-08-03 00:00:00', 'admin'),
(19, 'INV-07274502082025-9787', 3, 'user123', '2025-08-02 07:27:45', 3.00, 5400, 'shipping', '2025-08-03 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_product`
--

CREATE TABLE `invoice_product` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `color_name` varchar(255) DEFAULT NULL,
  `material_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice_product`
--

INSERT INTO `invoice_product` (`id`, `invoice_id`, `product_id`, `color_id`, `material_id`, `product_name`, `color_name`, `material_name`, `quantity`, `price`, `total_price`, `thumb`) VALUES
(16, 18, 34, 4, 58, 'iphone 14', 'đen', '512 GB', 1, 350, 350, 'ialFmsLHSe.png'),
(17, 19, 27, 1, 58, 'samsung s24', 'vàng', '512 GB', 2, 2250, 4500, ''),
(18, 19, 33, 5, 58, 'iPhone 15 Pro', 'trắng/bạc', '512 GB', 1, 900, 900, 'XMPQjNX2As.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_value_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_video` varchar(225) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `media_type` enum('default','attribute') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `media`
--

INSERT INTO `media` (`id`, `product_id`, `attribute_value_id`, `content`, `position`, `url`, `is_video`, `description`, `media_type`) VALUES
(174, 28, 5, '{\"name\":\"flST3ixxW2.jpg\",\"alt\":\"01\",\"size\":36345}', NULL, '', 'false', '', 'default'),
(175, 28, NULL, '{\"name\":\"HNH5dG7sgH.jpg\",\"alt\":\"default\",\"size\":76803}', NULL, '', 'false', '', 'default'),
(176, 28, 7, '{\"name\":\"fYC0oCXJfz.jpg\",\"alt\":\"02\",\"size\":31082}', NULL, '', 'false', '', 'default'),
(190, 34, NULL, '{\"name\":\"dm3oqUJISm.png\",\"alt\":\"default\",\"size\":573294}', NULL, '', 'false', '', 'default'),
(191, 34, 4, '{\"name\":\"ialFmsLHSe.png\",\"alt\":\"\\u0111en\",\"size\":154402}', NULL, '', 'false', '', 'default'),
(192, 34, 5, '{\"name\":\"AJaKNwaWlz.png\",\"alt\":null,\"size\":363678}', NULL, '', 'false', '', 'default'),
(193, 34, 3, '{\"name\":\"hIjiwe4qF3.jpg\",\"alt\":\"xanh d\\u01b0\\u01a1ng\",\"size\":43041}', NULL, '', 'false', '', 'default'),
(194, 34, NULL, '{\"name\":\"dCKdqzTqeI.jpg\",\"alt\":\"iPhone-14-01\",\"size\":52621}', NULL, '', 'false', '', 'default'),
(195, 33, 4, '{\"name\":\"8aL9fzRST1.jpg\",\"alt\":\"\\u0110en\",\"size\":17225}', NULL, '', 'false', '', 'default'),
(196, 33, 5, '{\"name\":\"XMPQjNX2As.jpg\",\"alt\":\"Tr\\u1eafng\",\"size\":40303}', NULL, '', 'false', '', 'default'),
(197, 33, NULL, '{\"name\":\"8Ln56BY8ej.jpg\",\"alt\":\"iPhone-15-03\",\"size\":3727}', NULL, '', 'false', '', 'default'),
(198, 33, NULL, '{\"name\":\"QIeazc6uih.png\",\"alt\":\"iPhone-15-01\",\"size\":164235}', NULL, '', 'false', '', 'default'),
(199, 33, NULL, '{\"name\":\"h2REYOV04T.jpg\",\"alt\":\"iPhone-15-02\",\"size\":5894}', NULL, '', 'false', '', 'default'),
(200, 32, 66, '{\"name\":\"WFS3XkFcUl.png\",\"alt\":\"iphone-16-pro-02\",\"size\":65864}', NULL, '', 'false', '', 'default'),
(201, 32, NULL, '{\"name\":\"MMJurrpyXF.png\",\"alt\":\"iphone-16-pro-01\",\"size\":1567757}', NULL, '', 'false', '', 'default'),
(202, 32, 65, '{\"name\":\"ifULhW1ZXd.png\",\"alt\":\"iphone-16-pro-03\",\"size\":190896}', NULL, '', 'false', '', 'default'),
(203, 32, 67, '{\"name\":\"fe3Q7fna8a.png\",\"alt\":\"iphone-16-pro-04\",\"size\":130570}', NULL, '', 'false', '', 'default'),
(204, 31, 2, '{\"name\":\"0k7Z4anaGg.png\",\"alt\":\"s22-utra-02\",\"size\":332600}', NULL, '', 'false', '', 'default'),
(205, 31, NULL, '{\"name\":\"ZrvSDRuiaK.jpg\",\"alt\":\"s22-utra-01\",\"size\":53837}', NULL, '', 'false', '', 'default'),
(206, 31, 4, '{\"name\":\"a6B5ZjRdgv.png\",\"alt\":\"s22-utra-03\",\"size\":294687}', NULL, '', 'false', '', 'default'),
(207, 31, 7, '{\"name\":\"Us7MrR1xY3.png\",\"alt\":\"s22-utra-04\",\"size\":303095}', NULL, '', 'false', '', 'default'),
(208, 31, 5, '{\"name\":\"D54naDgrgv.png\",\"alt\":\"s22-utra-05\",\"size\":326824}', NULL, '', 'false', '', 'default'),
(209, 30, 3, '{\"name\":\"QlQKHgfR2L.png\",\"alt\":\"sasungs25-01\",\"size\":160578}', NULL, '', 'false', '', 'default'),
(210, 30, 5, '{\"name\":\"j31l8JjvVb.png\",\"alt\":\"sasungs25-02\",\"size\":153689}', NULL, '', 'false', '', 'default'),
(211, 30, 4, '{\"name\":\"WWrSeRu38W.png\",\"alt\":\"sasungs25-03\",\"size\":129168}', NULL, '', 'false', '', 'default'),
(212, 29, NULL, '{\"name\":\"fucrsJPeVY.png\",\"alt\":\"oppo-01\",\"size\":139815}', NULL, '', 'false', '', 'default'),
(213, 29, 70, '{\"name\":\"jcIKlXjftY.jpg\",\"alt\":\"oppo-02\",\"size\":44541}', NULL, '', 'false', '', 'default'),
(214, 29, 68, '{\"name\":\"QvL0eruDDp.jpg\",\"alt\":\"oppo-03\",\"size\":36885}', NULL, '', 'false', '', 'default'),
(215, 29, 6, '{\"name\":\"D6NjJeUj6t.jpg\",\"alt\":\"oppo-02\",\"size\":76187}', NULL, '', 'false', '', 'default'),
(216, 35, 71, '{\"name\":\"c4CsezwVNU.jpg\",\"alt\":\"hong\",\"size\":11642}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(217, 35, 4, '{\"name\":\"y2LP66f8Sh.jpg\",\"alt\":\"den\",\"size\":46267}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(218, 35, 6, '{\"name\":\"e8f5CfJ2vo.jpg\",\"alt\":\"xam\",\"size\":56346}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(219, 35, 5, '{\"name\":\"0dhC8wGIHL.jpg\",\"alt\":\"trang\",\"size\":48490}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(231, 36, 4, '{\"name\":\"ILgeoq5AZ0.jpg\",\"alt\":\"den\",\"size\":62808}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(232, 36, 5, '{\"name\":\"JnWweJciVB.jpg\",\"alt\":\"trang\",\"size\":59789}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(233, 36, 3, '{\"name\":\"BtzAzUmwUp.jpg\",\"alt\":\"xanh\",\"size\":71311}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(234, 37, 70, '{\"name\":\"yxEydMtL7E.jpg\",\"alt\":\"cam\",\"size\":91176}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(235, 37, 4, '{\"name\":\"QwiP9fELWF.jpg\",\"alt\":\"den\",\"size\":86803}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(236, 37, 7, '{\"name\":\"Dvn15q6aVi.jpg\",\"alt\":\"lam\",\"size\":89468}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(237, 38, 4, '{\"name\":\"KJxa6tljOR.jpg\",\"alt\":\"den\",\"size\":66670}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(238, 38, 3, '{\"name\":\"Mp697YLnf2.jpg\",\"alt\":\"xanh\",\"size\":104996}', NULL, '', 'false', 'image not for attribute_values', 'default'),
(248, 27, 1, '{\"name\":\"avKZG7M7YT.jpg\",\"alt\":\"vang\",\"size\":87681}', NULL, '', 'false', '', 'default'),
(249, 27, 4, '{\"name\":\"cqU6Ke2mrt.jpg\",\"alt\":\"den\",\"size\":23059}', NULL, '', 'false', '', 'default'),
(250, 27, 6, '{\"name\":\"74DOLuEuom.jpg\",\"alt\":\"xam\",\"size\":20665}', NULL, '', 'false', '', 'default'),
(251, 27, 68, '{\"name\":\"weqzZwB12Q.jpg\",\"alt\":\"tim\",\"size\":88644}', NULL, '', 'false', '', 'default'),
(252, 27, NULL, '{\"name\":\"0KNQByuJlB.jpg\",\"alt\":\"default\",\"size\":61967}', NULL, '', 'false', '', 'default');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(10) DEFAULT '''0''',
  `url` varchar(255) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `type_menu` varchar(255) DEFAULT NULL,
  `type_open` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `container` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id`, `name`, `status`, `url`, `ordering`, `type_menu`, `type_open`, `parent_id`, `container`, `note`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Trang chủ', 'active', '/', 1, 'link', 'new_window', NULL, NULL, 'main-menu', NULL, NULL, '2024-10-26 00:00:00', 'admin'),
(2, 'Sản phẩm', 'inactive', '#', 3, 'category_product', 'current', NULL, NULL, '<p>main-menu</p>', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(3, 'Blog', 'inactive', '#', 4, 'category_article', 'current', NULL, NULL, '<p>main-menu</p>', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(8, 'Tin tức tổng hợp', 'active', '/rss/tin-tuc-tong-hop', 7, 'category_product', 'current', NULL, NULL, '<p>main-menu</p>', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(9, 'Hình ảnh', 'active', '/thu-vien-hinh-anh', 6, 'link', 'current', NULL, NULL, '<p>main-menu</p>', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(10, 'Liên hệ', 'active', '/lien-he', 8, 'link', 'current', NULL, NULL, '<p>main-menu</p>', '2024-08-08 00:00:00', 'admin', '2025-07-08 00:00:00', 'admin'),
(20, 'Danh Mục', 'active', '#', 2, 'link', 'current', NULL, 'category', 'Đây là nơi đặt Category menu đa cấp', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(21, 'Article-container', 'inactive', '/', 15, 'category_article', 'current', 3, 'article', '<p>Article container</p>', NULL, NULL, '2025-07-08 00:00:00', 'admin'),
(30, 'Zendvn', 'active', 'https://zendvn.com/', 5, 'link', '_new', NULL, NULL, '<p>Trang web zendvn</p>', '2024-02-28 00:00:00', 'admin', '2025-07-08 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menusmartphone`
--

CREATE TABLE `menusmartphone` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(10) DEFAULT '''0''',
  `url` varchar(255) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `type_menu` varchar(255) DEFAULT NULL,
  `type_open` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `container` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menusmartphone`
--

INSERT INTO `menusmartphone` (`id`, `name`, `status`, `url`, `ordering`, `type_menu`, `type_open`, `parent_id`, `container`, `note`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Trang chủ', 'active', '/phone', 1, 'link', 'current', NULL, NULL, 'main-menu', NULL, NULL, '2025-07-10 00:00:00', 'admin'),
(2, 'Sản phẩm', 'active', '/phone/phoneCategory', 2, 'category_product', 'current', NULL, NULL, '<p>main-menu</p>', NULL, NULL, '2025-07-11 00:00:00', 'admin'),
(3, 'Danh Mục', 'active', '/phone/phoneCategory', 3, 'link', 'current', NULL, 'category', 'Đây là nơi đặt Category menu đa cấp', NULL, NULL, '2025-07-10 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_translations`
--

CREATE TABLE `menu_translations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `locale` varchar(225) DEFAULT NULL,
  `menu_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_translations`
--

INSERT INTO `menu_translations` (`id`, `name`, `locale`, `menu_id`) VALUES
(1, 'Home', 'en', '1'),
(2, 'Trang chủ', 'vi', '1'),
(3, 'Product', 'en', '2'),
(4, 'Sản phẩm', 'vi', '2'),
(5, 'Blog', 'en', '3'),
(6, 'Blog', 'vi', '3'),
(7, 'Brain-Training Riddles', 'en', '4'),
(8, 'câu đố trí não', 'vi', '4'),
(9, 'Test-02', 'en', '5'),
(10, 'Test-02', 'vi', '5'),
(11, 'Category', 'en', '6'),
(12, 'Category', 'vi', '6'),
(13, 'Article', 'en', '7'),
(14, 'Article', 'vi', '7'),
(15, 'news summary', 'en', '8'),
(16, 'Tin tức tổng hợp', 'vi', '8'),
(17, 'Gallery', 'en', '9'),
(18, 'Hình ảnh', 'vi', '9'),
(19, 'Contact', 'en', '10'),
(20, 'Liên hệ', 'vi', '10'),
(21, 'Directory', 'en', '20'),
(22, 'Danh mục', 'vi', '20'),
(23, 'Article-container', 'en', '21'),
(24, 'Article-container', 'vi', '21'),
(25, 'Education', 'en', '23'),
(26, 'Giáo dục', 'vi', '23'),
(27, 'Ultraviolet rays', 'en', '24'),
(28, 'Tia cực tím', 'vi', '24'),
(29, 'Zendvn', 'en', '30'),
(30, 'Zendvn', 'vi', '30'),
(31, 'Sport', 'en', '37'),
(32, 'Thể thao', 'vi', '37'),
(33, 'Health', 'en', '38'),
(34, 'Sức khỏe', 'vi', '38'),
(35, 'Science', 'en', '39'),
(36, 'Khoa học', 'vi', '39'),
(37, 'Digitalization', 'en', '40'),
(38, 'Số hóa', 'vi', '40'),
(39, 'Business', 'en', '41'),
(40, 'Kinh doanh', 'vi', '41'),
(41, 'Ultraviolet rays', 'en', '43'),
(42, 'Tia cực tím', 'vi', '43'),
(43, 'Blockchain and AI', 'en', '44'),
(44, 'Blockchain và trí tuệ nhân tạou', 'vi', '44'),
(45, 'UK university launches happiness course', 'en', '45'),
(46, 'Trường đại học Anh ra mắt khóa học hạnh phúc', 'vi', '45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_02_26_042416_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(16, 'App\\Models\\UserModel', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `controller_select` varchar(255) DEFAULT NULL,
  `permission_action` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `controller_select`, `permission_action`) VALUES
(11, 'delete-user', 'web', '2025-03-14 17:00:00', NULL, 'UserController', 'delete'),
(12, 'access-article', 'web', '2025-03-14 17:00:00', NULL, 'ArticleController', 'access'),
(13, 'create-article', 'web', '2025-03-14 17:00:00', NULL, 'ArticleController', 'create'),
(14, 'edit-article', 'web', '2025-03-14 17:00:00', NULL, 'ArticleController', 'edit'),
(15, 'delete-article', 'web', '2025-03-14 17:00:00', NULL, 'ArticleController', 'delete'),
(16, 'access-user', 'web', '2025-03-14 17:00:00', NULL, 'UserController', 'access'),
(17, 'create-user', 'web', '2025-03-14 17:00:00', NULL, 'UserController', 'create'),
(18, 'edit-user', 'web', '2025-03-14 17:00:00', NULL, 'UserController', 'edit');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phonecontact`
--

CREATE TABLE `phonecontact` (
  `id` int(11) NOT NULL,
  `phonenumber` int(200) NOT NULL,
  `status` varchar(225) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phonecontact`
--

INSERT INTO `phonecontact` (`id`, `phonenumber`, `status`, `created`) VALUES
(1, 11111, 'active', '2024-07-04 00:00:00'),
(3, 1113333, 'inactive', '2024-07-04 08:43:00'),
(4, 1234567890, 'inactive', '2024-07-05 11:53:00'),
(5, 1111111111, 'inactive', '2024-07-06 13:01:00'),
(9, 1212121212, 'inactive', '2025-05-18 10:32:00'),
(10, 1212121212, 'inactive', '2025-05-18 10:32:00'),
(11, 1212121212, 'inactive', '2025-05-18 10:39:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `category_product_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(225) DEFAULT NULL,
  `maketing_price` int(11) DEFAULT NULL,
  `is_new` int(11) DEFAULT NULL,
  `is_sale` int(11) DEFAULT NULL,
  `is_best_seller` int(11) DEFAULT NULL,
  `is_show_contact` int(11) DEFAULT NULL,
  `is_availabe` int(11) DEFAULT NULL,
  `total_rating` int(11) DEFAULT NULL,
  `fieldClass` varchar(255) DEFAULT NULL,
  `fieldWeb` varchar(255) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price_discount_value` int(255) DEFAULT NULL,
  `price_discount_percent` int(255) DEFAULT NULL,
  `price_discount_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `slug`, `category_product_id`, `description`, `status`, `price`, `created`, `created_by`, `maketing_price`, `is_new`, `is_sale`, `is_best_seller`, `is_show_contact`, `is_availabe`, `total_rating`, `fieldClass`, `fieldWeb`, `modified_by`, `modified`, `type`, `price_discount_value`, `price_discount_percent`, `price_discount_type`) VALUES
(27, 'samsung s24', 'bv-samsung-s24-39', 9, '<p><strong>Samsung s24</strong> l&agrave; si&ecirc;u phẩm&nbsp;<strong>smartphone</strong>&nbsp;đỉnh cao mở đầu năm 2024 đến từ nh&agrave; Samsung với chip&nbsp;<strong>Snapdragon 8 Gen 3 For Galaxy</strong>&nbsp;mạnh mẽ, c&ocirc;ng nghệ tương lai&nbsp;<strong>Galaxy AI</strong>&nbsp;c&ugrave;ng&nbsp;<strong>khung viền Titan</strong>&nbsp;đẳng cấp hứa hẹn sẽ mang tới nhiều sự thay đổi lớn về mặt thiết kế v&agrave; cấu h&igrave;nh.&nbsp;<strong>SS&nbsp;Galaxy S24 bản Ultra</strong>&nbsp;sở hữu m&agrave;n h&igrave;nh&nbsp;<strong>6.8 inch</strong>&nbsp;<strong>Dynamic AMOLED 2X</strong>&nbsp;tần số qu&eacute;t&nbsp;<strong>120Hz</strong>. M&aacute;y cũng sở hữu&nbsp;<strong>camera ch&iacute;nh 200MP</strong>, camera zoom quang học 50MP, camera tele 10MP v&agrave; camera g&oacute;c si&ecirc;u rộng 12MP.</p>\r\n\r\n<p>&nbsp;</p>', 'active', 2000, '2025-01-06 00:00:00', 'admin', 1800, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-08-07 00:00:00', 'feature', 0, 10, 'percent'),
(28, 'iphone 15', 'bv-iphone-15-39', 8, '<p><strong>iPhone 15 Pro Max&nbsp;</strong>hứa hẹn đem tới trải nghiệm h&igrave;nh ảnh với độ sắc n&eacute;t v&agrave; mượt m&agrave; cao nhờ sở hữu m&agrave;n h&igrave;nh&nbsp;<strong>Super Retina XDR OLED 6.7 inch</strong>&nbsp;tần số qu&eacute;t&nbsp;<strong>120Hz</strong>. Nhờ vận h&agrave;nh với&nbsp;<strong>chipset A17 Pro</strong>&nbsp;sản xuất tr&ecirc;n tiến tr&igrave;nh 3nm,&nbsp;thế hệ&nbsp;<a href=\"https://cellphones.com.vn/mobile/apple/iphone-15.html\" target=\"_blank\"><strong>iPhone 15</strong></a>&nbsp;bản Pro Max&nbsp;đảm bảo vận h&agrave;nh mạnh mẽ v&agrave; tiết kiệm pin tối ưu. Đặc biệt, m&aacute;y c&ograve;n sở hữu cụm c<strong>amera ch&iacute;nh 48MP</strong>&nbsp;c&ugrave;ng khả năng&nbsp;<strong>zoom quang học 5x</strong>, gi&uacute;p iPhone 15 Pro Max trở th&agrave;nh lựa chọn tuyệt vời cho người đam m&ecirc; nhiếp ảnh v&agrave; quay phim chuy&ecirc;n nghiệp.</p>', 'active', 2000, '2025-01-06 00:00:00', 'admin', 2000, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-07-19 00:00:00', 'feature', 0, 0, 'percent'),
(29, 'OPPO Reno10 Pro', 'bv-oppo-reno10-pro-39', 11, '<p>B&ecirc;n cạnh đ&oacute;, với bộ nhớ RAM 12 GB, OPPO Reno10 Pro&nbsp;Plus c&oacute; thể đối ph&oacute; với t&aacute;c vụ đa nhiệm, cho ph&eacute;p bạn mở nhiều ứng dụng c&ugrave;ng một l&uacute;c m&agrave; kh&ocirc;ng gặp bất kỳ kh&oacute; khăn n&agrave;o về hiệu suất. Kết hợp với dung lượng bộ nhớ trong l&ecirc;n tới 256 GB v&agrave; khe cắm thẻ nhớ microSD, chiếc smartphone n&agrave;y kh&ocirc;ng chỉ đảm bảo hiệu suất mượt m&agrave;, m&agrave; c&ograve;n cung cấp kh&ocirc;ng gian lưu trữ rộng lớn để lưu trữ v&agrave; truy cập dữ liệu nhanh ch&oacute;ng, tiện lợi.</p>', 'active', 1200, '2025-02-06 00:00:00', 'admin', 1080, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-08-06 00:00:00', 'feature', 500, 10, 'percent'),
(30, 'samsung s25 ultra', 'bv-samsung-s25-40', 9, '<h2><strong>Điện thoại Samsung S25 AI mới c&oacute; g&igrave; hấp dẫn?</strong></h2>\r\n\r\n<p>Samsung Galaxy S25 được t&iacute;ch hợp t&iacute;nh năng AI - c&ocirc;ng nghệ xu hướng để đem đến cho người d&ugrave;ng những trải nghiệm vượt trội v&agrave; th&ocirc;ng minh hơn. Cụ thể:</p>\r\n\r\n<p><strong>T&igrave;m kiếm th&ocirc;ng tin nhanh gấp 3 lần</strong></p>\r\n\r\n<p>T&iacute;nh năng AI tr&ecirc;n S25 đ&atilde; tăng tốc độ t&igrave;m kiếm c&aacute;c th&ocirc;ng tin một c&aacute;ch nhanh ch&oacute;ng v&agrave; vượt trội hơn gấp 3 lần với AI Agent. Kết hợp với Circle to Search, bạn c&oacute; thể t&igrave;m kiếm một c&aacute;ch trực quan, tăng t&iacute;nh hiệu quả bằng c&aacute;ch khoanh tr&ograve;n v&agrave;o mục cần t&igrave;m.</p>\r\n\r\n<p>Ngo&agrave;i ra, bạn c&oacute; thể kh&aacute;m ph&aacute; th&ecirc;m ngay mẫu phi&ecirc;n bản&nbsp;<strong>S25 512GB</strong>&nbsp;đặc biệt với n&acirc;ng cấp về bộ nhớ gi&uacute;p c&aacute;c thao t&aacute;c quay chụp trở n&ecirc;n mượt m&agrave; v&agrave; chơi game, xem film lướt web mượt m&agrave; hơn. C&ugrave;ng kh&aacute;m ph&aacute; ngay nh&eacute;!</p>', 'active', 3000, '2025-06-03 00:00:00', 'admin', 2100, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-07-19 00:00:00', 'feature', 1000, 30, 'percent'),
(31, 'Samsung Galaxy S22 Ultra', 'bv-samsung-s22-ultra-41', 9, '<h2>Đặc điểm nổi bật của Samsung Galaxy S22 Ultra 8GB 128GB</h2>\r\n\r\n<p>Đ&uacute;ng như c&aacute;c th&ocirc;ng tin được đồn đo&aacute;n trước đ&oacute;, mẫu flagship mới của gả khổng lồ H&agrave;n Quốc được ra mắt với t&ecirc;n gọi l&agrave; Samsung Galaxy S22 Ultra với nhiều cải tiến đ&aacute;ng gi&aacute;. Mẫu điện thoại cao cấp đến từ Samsung n&agrave;y c&oacute; nhiều thay đổi từ thiết kế, cấu h&igrave;nh cho đến camera. Vậy si&ecirc;u phẩm n&agrave;y c&oacute; g&igrave; mới, gi&aacute; bao nhi&ecirc;u v&agrave; c&oacute; n&ecirc;n mua kh&ocirc;ng? H&atilde;y c&ugrave;ng t&igrave;m hiểu chi tiết ngay b&ecirc;n dưới nh&eacute;!</p>\r\n\r\n<p>Dự kiến v&agrave;o th&aacute;ng 2, Samsung sẽ cho ra mắt si&ecirc;u phẩm&nbsp;<a href=\"https://cellphones.com.vn/samsung-galaxy-s23-ultra.html\" target=\"_blank\"><strong>S23 Ultra</strong></a>&nbsp;m&agrave; c&oacute; thể qu&yacute; kh&aacute;ch sẽ quan t&acirc;m! Click v&agrave;o link để t&igrave;m hiểu th&ecirc;</p>', 'active', 4000, '2025-06-03 00:00:00', 'admin', 3000, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-07-19 00:00:00', 'feature', 0, 25, 'percent'),
(32, 'iPhone 16 Pro', 'iPhone 16 Pro', 8, '<h2>Đặc điểm nổi bật của iPhone 16 Pro Max 256GB | Ch&iacute;nh h&atilde;ng VN/A</h2>\r\n\r\n<p><strong>iPhone 16 Pro Max</strong>&nbsp;sở hữu&nbsp;<strong>m&agrave;n h&igrave;nh Super Retina XDR OLED 6.9 inch</strong>&nbsp;với&nbsp;<strong>c&ocirc;ng nghệ ProMotion</strong>, mang lại trải nghiệm hiển thị mượt m&agrave; v&agrave; sắc n&eacute;t, l&yacute; tưởng cho giải tr&iacute; v&agrave; l&agrave;m việc. Với chipset&nbsp;<strong>A18 Pro</strong>&nbsp;mạnh mẽ, mẫu iPhone đời mới n&agrave;y cung cấp hiệu suất vượt trội, gi&uacute;p xử l&yacute; mượt m&agrave; c&aacute;c t&aacute;c vụ nặng như chơi game hay edit video.&nbsp;Chiếc điện thoại&nbsp;<strong>iPhone 16</strong>&nbsp;mới&nbsp;n&agrave;y c&ograve;n sở hữu&nbsp;hệ thống&nbsp;<strong>camera Ultra Wide 48MP</strong>&nbsp;cho khả năng chụp ảnh cực kỳ chi tiết, mang đến chất lượng h&igrave;nh ảnh ấn tượng trong mọi t&igrave;nh huống.</p>\r\n\r\n<p>&nbsp;</p>', 'active', NULL, '2025-06-03 00:00:00', 'admin', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-08-06 00:00:00', 'feature', 220, 10, 'percent'),
(33, 'iPhone 15 Pro', 'iPhone 15 Pro', 8, '<h2><strong>V&igrave; sao n&ecirc;n chọn mua điện thoại&nbsp;iPhone 15 256GB</strong></h2>\r\n\r\n<p><strong>iPhone 15 128GB</strong>&nbsp;l&agrave; phi&ecirc;n bản&nbsp;<strong>ti&ecirc;u chuẩn (thường)</strong>&nbsp;trong&nbsp;<strong>iPhone 15 series</strong>&nbsp;vừa được ch&iacute;nh thức ra mắt. Chiếc điện thoại n&agrave;y c&ograve;n c&oacute; 2 dung lượng bộ nhớ lớn hơn l&agrave; 256Gb v&agrave; 512GB. C&ugrave;ng t&igrave;m hiểu chi tiết hơn về&nbsp;<strong>iPhone 15 256GB</strong>&nbsp;nh&eacute;:</p>\r\n\r\n<ul>\r\n	<li>D&ograve;ng iPhone 15 phi&ecirc;n bản 256GB l&agrave; một biểu tượng của sự cao cấp v&agrave; mạnh mẽ. Sản phẩm được trang bị m&agrave;n h&igrave;nh&nbsp;<strong>OLED Dynamic Island</strong>&nbsp;k&iacute;ch thước&nbsp;<strong>6.1 inch</strong>&nbsp;mang lại sự sống động v&agrave; ch&acirc;n thực cho mọi h&igrave;nh ảnh v&agrave; video.</li>\r\n	<li>B&ecirc;n trong, chiếc điện thoại n&agrave;y được cung cấp sức mạnh bởi con&nbsp;<strong>chip Apple A16 Bionic</strong>, với CPU 6 l&otilde;i v&agrave; GPU 5 l&otilde;i, đảm bảo khả năng xử l&yacute; tốt v&agrave; mượt m&agrave; trong tất cả c&aacute;c t&aacute;c vụ. Kể cả chơi c&aacute;c tựa game nặng cũng kh&ocirc;ng bị giật, lag g&acirc;y cảm gi&aacute;c kh&oacute; chịu.</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>', 'active', 1000, '2025-06-03 00:00:00', 'admin', 900, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-07-19 00:00:00', 'normal', 500, 10, 'percent'),
(34, 'iphone 14', 'iphone 14', 8, '<p>Mới đ&acirc;y, Apple đ&atilde; tổ chức sự kiện Far Out ra mắt c&aacute;c sản phẩm mới của năm 2022. C&ocirc;ng ty đ&atilde; giới thiệu d&ograve;ng&nbsp;iPhone 14 Series&nbsp;được rất nhiều người d&ugrave;ng chờ đợi kể từ khi những tin đồn đầu ti&ecirc;n xuất hiện v&agrave;o hồi đầu năm. Sản phẩm năm nay kh&ocirc;ng chỉ cải tiến về thiết kế m&agrave; c&ograve;n được cung cấp sức mạnh vượt trội từ con chip A15 Bionic. H&atilde;y c&ugrave;ng Ho&agrave;ng H&agrave; Mobile kh&aacute;m ph&aacute; những ưu điểm của chiếc iPhone 14 ch&iacute;nh h&atilde;ng VN/A nh&eacute;.</p>', 'active', 500, '2025-06-05 00:00:00', 'admin', 350, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-07-19 00:00:00', 'normal', 1000, 30, 'percent'),
(35, 'Samsung A56', 'bv-samsung-15-39', 9, '<p><strong>Điện thoại&nbsp;Samsung A56 5G</strong>&nbsp;sở hữu&nbsp;<strong>m&agrave;n h&igrave;nh Super AMOLED 6,7 inch</strong>&nbsp;độ ph&acirc;n giải FHD+ v&agrave;&nbsp;<strong>tần số qu&eacute;t 120 Hz</strong>, đem tới trải nghiệm xem sắc n&eacute;t v&agrave; mượt m&agrave;. Thiết bị trang bị&nbsp;<strong>chip Exynos 1580</strong>&nbsp;tiến tr&igrave;nh 4nm, gi&uacute;p xử l&yacute; đa nhiệm nhanh ch&oacute;ng, tối ưu hiệu năng. Vi&ecirc;n&nbsp;<strong>pin 5000mAh</strong>&nbsp;hỗ trợ&nbsp;<strong>sạc nhanh 45W</strong>&nbsp;cung cấp cho m&aacute;y thời lượng sử dụng cả ng&agrave;y d&agrave;i m&agrave; kh&ocirc;ng lo gi&aacute;n đoạn.</p>', 'active', 1500, '2025-08-06 00:00:00', 'admin', 1425, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '2025-08-06 00:00:00', 'normal', 100, 5, 'percent'),
(36, 'oppo find x8 pro', NULL, 11, '<p>Oppo Find X8 Pro 5G 16GB/512GB g&acirc;y ấn tượng nhờ thiết kế tinh xảo, kết hợp h&agrave;i h&ograve;a giữa sự vu&ocirc;ng vức v&agrave; độ bo cong nhẹ, gi&uacute;p thoải m&aacute;i khi cầm nắm. Với mặt trước v&agrave; sau l&agrave;m từ k&iacute;nh cường lực cong nhẹ bốn g&oacute;c, sản phẩm mang đến vẻ c&acirc;n đối v&agrave; hiện đại. Cụm camera h&igrave;nh tr&ograve;n lớn nằm ch&iacute;nh giữa mặt lưng tạo n&ecirc;n n&eacute;t đối xứng độc đ&aacute;o v&agrave; dễ nh&igrave;n. Phần m&agrave;n h&igrave;nh cong nhẹ c&ugrave;ng viền mỏng chỉ 1.45mm mang lại trải nghiệm h&igrave;nh ảnh rộng r&atilde;i.</p>', 'active', 1000, '2025-08-07 00:00:00', 'admin', 950, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', 200, 5, 'percent'),
(37, 'Điện thoại Oppo Reno12f', NULL, 11, '<p>Để l&agrave;m cho mặt trước của điện thoại trở n&ecirc;n gọn g&agrave;ng hơn, lỗ cảm biến &aacute;nh s&aacute;ng được giấu ở ph&iacute;a tr&ecirc;n m&agrave;n h&igrave;nh. Miếng d&aacute;n bảo vệ m&agrave;n h&igrave;nh c&oacute; khả năng truyền &aacute;nh s&aacute;ng k&eacute;m, chẳng hạn như miếng d&aacute;n c&oacute; m&agrave;u hoặc tối, c&oacute; thể chặn lỗ cảm biến &aacute;nh s&aacute;ng v&agrave; ảnh hưởng đến việc sử dụng b&igrave;nh thường của điện thoại.</p>', 'active', 2200, '2025-08-07 00:00:00', 'admin', 1760, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', 1000, 20, 'percent'),
(38, 'oppo a58', NULL, 11, '<p><strong>OPPO A58</strong>&nbsp;c&oacute; những thiết kế nổi bật ngo&agrave;i sự mong đợi.&nbsp;<strong>OPPO A58</strong>&nbsp;sở hữu cấu h&igrave;nh ấn tượng với chip&nbsp;<strong>Dimensity 700</strong>&nbsp;v&agrave; khả năng đa nhiệm của&nbsp;<strong>RAM 6GB</strong>, bộ nhớ trong&nbsp;<strong>128GB</strong>. Chưa dừng ở đ&oacute;, OPPO A58 c&ograve;n đang được hy vọng sẽ trang bị vi&ecirc;n pin&nbsp;<strong>5.000 mAh</strong>&nbsp;c&ugrave;ng m&agrave;n h&igrave;nh&nbsp;<strong>6.72 inch LCD</strong>&nbsp;sẽ mang đến những trải nghiệm đặc biệt.</p>', 'active', 3000, '2025-08-07 00:00:00', 'admin', 2700, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', 200, 10, 'percent');

--
-- Bẫy `product`
--
DELIMITER $$
CREATE TRIGGER `before_product_media_delete` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM media
    WHERE product_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_product_product_attribute_price_delete` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM product_attribute_price
    WHERE product_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_product_product_has_attribute_delete` BEFORE DELETE ON `product` FOR EACH ROW DELETE FROM product_has_attribute 
    WHERE product_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_attribute_price`
--

CREATE TABLE `product_attribute_price` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `color_name` varchar(255) DEFAULT NULL,
  `material_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `status` varchar(225) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_attribute_price`
--

INSERT INTO `product_attribute_price` (`id`, `product_id`, `color_id`, `material_id`, `product_name`, `color_name`, `material_name`, `price`, `status`, `ordering`, `default`) VALUES
(73, 27, 1, 57, 'samsung s24', 'vàng', '256 GB', 2000, 'active', 10, 1),
(110, 27, 1, 58, 'samsung s24', 'vàng', '512 GB', 2050, 'active', 13, 0),
(113, 34, 3, 58, 'iphone 14', 'xanh dương', '512 GB', 500, 'active', 29, 0),
(114, 34, 4, 58, 'iphone 14', 'đen', '512 GB', 500, 'active', 30, 1),
(115, 34, 5, 58, 'iphone 14', 'trắng/bạc', '512 GB', 500, 'active', 31, 0),
(116, 33, 4, 58, 'iPhone 15 Pro', 'đen', '512 GB', 3000, 'active', 32, 0),
(117, 33, 5, 58, 'iPhone 15 Pro', 'trắng/bạc', '512 GB', 3000, 'active', 33, 1),
(118, 28, 5, 56, 'iphone 15', 'trắng/bạc', '128 GB', 1800, 'active', 34, 0),
(119, 28, 5, 57, 'iphone 15', 'trắng/bạc', '256 GB', 1850, 'active', 35, 0),
(120, 28, 5, 58, 'iphone 15', 'trắng/bạc', '512 GB', 1900, 'active', 36, 0),
(124, 28, 7, 56, 'iphone 15', 'xanh lục', '128 GB', 2000, 'active', 37, 1),
(125, 28, 7, 57, 'iphone 15', 'xanh lục', '256 GB', 2100, 'active', 38, 0),
(126, 28, 7, 58, 'iphone 15', 'xanh lục', '512 GB', 2150, 'active', 39, 0),
(128, 32, 65, 58, 'iPhone 16 Pro', 'titan tự nhiên', '512 GB', 2000, 'active', 40, 1),
(129, 32, 66, 58, 'iPhone 16 Pro', 'titan sa mạc', '512 GB', 2100, 'active', 41, 0),
(130, 32, 67, 58, 'iPhone 16 Pro', 'titan đen', '512 GB', 2200, 'active', 42, 0),
(131, 31, 2, 58, 'Samsung Galaxy S22 Ultra', 'đỏ', '512 GB', 4000, 'active', 43, 1),
(132, 31, 4, 58, 'Samsung Galaxy S22 Ultra', 'đen', '512 GB', 4100, 'active', 44, 0),
(133, 31, 5, 58, 'Samsung Galaxy S22 Ultra', 'trắng/bạc', '512 GB', 4150, 'active', 45, 0),
(134, 31, 7, 58, 'Samsung Galaxy S22 Ultra', 'xanh lục', '512 GB', 4200, 'active', 46, 0),
(135, 30, 3, 56, 'samsung s25 ultra', 'xanh dương', '128 GB', 3000, 'active', 47, 1),
(136, 30, 3, 57, 'samsung s25 ultra', 'xanh dương', '256 GB', 3100, 'active', 48, 0),
(137, 30, 3, 58, 'samsung s25 ultra', 'xanh dương', '512 GB', 3150, 'active', 49, 0),
(138, 30, 4, 56, 'samsung s25 ultra', 'đen', '128 GB', 3200, 'active', 50, 0),
(139, 30, 4, 57, 'samsung s25 ultra', 'đen', '256 GB', 3250, 'active', 51, 0),
(140, 30, 4, 58, 'samsung s25 ultra', 'đen', '512 GB', 3300, 'active', 52, 0),
(141, 30, 5, 56, 'samsung s25 ultra', 'trắng/bạc', '128 GB', 3200, 'active', 53, 0),
(142, 30, 5, 57, 'samsung s25 ultra', 'trắng/bạc', '256 GB', 3250, 'active', 54, 0),
(143, 30, 5, 58, 'samsung s25 ultra', 'trắng/bạc', '512 GB', 3300, 'active', 55, 0),
(144, 27, 4, 57, 'samsung s24', 'đen', '256 GB', 2100, 'active', 56, 0),
(145, 27, 4, 58, 'samsung s24', 'đen', '512 GB', 2050, 'active', 57, 0),
(146, 29, 6, 57, 'OPPO Reno10 Pro', 'xám', '256 GB', 1200, 'active', 58, 0),
(147, 29, 6, 58, 'OPPO Reno10 Pro', 'xám', '512 GB', 1250, 'active', 59, 0),
(148, 29, 68, 57, 'OPPO Reno10 Pro', 'tím', '256 GB', 1200, 'active', 60, 1),
(149, 29, 68, 58, 'OPPO Reno10 Pro', 'tím', '512 GB', 1250, 'active', 61, 0),
(150, 29, 70, 57, 'OPPO Reno10 Pro', 'cam', '256 GB', 1200, 'active', 62, 0),
(151, 29, 70, 58, 'OPPO Reno10 Pro', 'cam', '512 GB', 1250, 'active', 63, 0),
(152, 35, 4, 56, 'Samsung A56', 'đen', '128 GB', 1500, 'active', 64, 1),
(153, 35, 5, 56, 'Samsung A56', 'trắng/bạc', '128 GB', 1500, 'active', 65, 0),
(154, 35, 6, 56, 'Samsung A56', 'xám', '128 GB', 1550, 'active', 66, 0),
(155, 35, 71, 56, 'Samsung A56', 'hồng', '128 GB', 1600, 'active', 67, 0),
(156, 27, 6, 57, 'samsung s24', 'xám', '256 GB', 2000, 'active', 68, 0),
(157, 27, 6, 58, 'samsung s24', 'xám', '512 GB', 2050, 'active', 69, 0),
(158, 27, 68, 57, 'samsung s24', 'tím', '256 GB', 2100, 'active', 70, 0),
(159, 27, 68, 58, 'samsung s24', 'tím', '512 GB', 2150, 'active', 71, 0),
(160, 36, 3, 56, 'oppo find x8 pro', 'xanh dương', '128 GB', 1000, 'active', 72, 1),
(161, 36, 3, 57, 'oppo find x8 pro', 'xanh dương', '256 GB', 1050, 'active', 73, 0),
(162, 36, 4, 56, 'oppo find x8 pro', 'đen', '128 GB', 1000, 'active', 74, 0),
(163, 36, 4, 57, 'oppo find x8 pro', 'đen', '256 GB', 1050, 'active', 75, 0),
(164, 36, 5, 56, 'oppo find x8 pro', 'trắng/bạc', '128 GB', 1000, 'active', 76, 0),
(165, 36, 5, 57, 'oppo find x8 pro', 'trắng/bạc', '256 GB', 150, 'active', 77, 0),
(166, 37, 4, 56, 'Điện thoại Oppo Reno12f', 'đen', '128 GB', 2000, 'active', 78, 0),
(167, 37, 7, 56, 'Điện thoại Oppo Reno12f', 'xanh lục', '128 GB', 2100, 'active', 79, 0),
(168, 37, 70, 56, 'Điện thoại Oppo Reno12f', 'cam', '128 GB', 2200, 'active', 80, 1),
(169, 38, 3, 56, 'oppo a58', 'xanh dương', '128 GB', 3000, 'active', 81, 1),
(170, 38, 3, 57, 'oppo a58', 'xanh dương', '256 GB', 3050, 'active', 82, 0),
(171, 38, 4, 56, 'oppo a58', 'đen', '128 GB', 3000, 'active', 83, 0),
(172, 38, 4, 57, 'oppo a58', 'đen', '256 GB', 3050, 'active', 84, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_has_attribute`
--

CREATE TABLE `product_has_attribute` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `attribute_value_id` int(11) DEFAULT NULL,
  `product_name` varchar(225) DEFAULT NULL,
  `attribute_value_name` varchar(225) DEFAULT NULL,
  `product_id_relation` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `default` varchar(255) DEFAULT NULL,
  `fieldClass` varchar(255) DEFAULT NULL,
  `status` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_has_attribute`
--

INSERT INTO `product_has_attribute` (`id`, `product_id`, `attribute_value_id`, `product_name`, `attribute_value_name`, `product_id_relation`, `ordering`, `default`, `fieldClass`, `status`) VALUES
(132, 27, 1, 'samsung s24', 'vàng', NULL, NULL, 'true', NULL, 'active'),
(135, 27, 58, 'samsung s24', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(138, 28, 56, 'iphone 15', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(141, 28, 57, 'iphone 15', '256 GB', NULL, NULL, NULL, NULL, 'active'),
(146, 27, 57, 'samsung s24', '256 GB', NULL, NULL, NULL, NULL, 'active'),
(151, 29, 58, 'OPPO Reno10 Pro', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(156, 28, 58, 'iphone 15', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(157, 29, 57, 'OPPO Reno10 Pro', '256 GB', NULL, NULL, NULL, NULL, 'active'),
(160, 30, 57, 'samsung s25', '256 GB', NULL, NULL, NULL, NULL, 'active'),
(161, 30, 58, 'samsung s25', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(162, 30, 59, 'samsung s25', 'zenvn', NULL, NULL, NULL, NULL, 'active'),
(164, 31, 58, 'Samsung Galaxy S22 Ultra', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(167, 32, 58, 'iPhone 16 Pro', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(168, 32, 59, 'iPhone 16 Pro', 'zenvn', NULL, NULL, NULL, NULL, 'active'),
(171, 33, 58, 'iPhone 15 Pro', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(172, 33, 59, 'iPhone 15 Pro', 'zenvn', NULL, NULL, NULL, NULL, 'active'),
(175, 34, 58, 'iphone 14', '512 GB', NULL, NULL, NULL, NULL, 'active'),
(176, 34, 3, 'iphone 14', 'xanh dương', NULL, NULL, NULL, NULL, 'active'),
(177, 34, 4, 'iphone 14', 'đen', NULL, NULL, NULL, NULL, 'active'),
(178, 34, 5, 'iphone 14', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(179, 33, 4, 'iPhone 15 Pro', 'đen', NULL, NULL, NULL, NULL, 'active'),
(180, 33, 5, 'iPhone 15 Pro', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(181, 28, 5, 'iphone 15', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(183, 28, 7, 'iphone 15', 'xanh lục', NULL, NULL, NULL, NULL, 'active'),
(185, 32, 65, 'iPhone 16 Pro', 'titan tự nhiên', NULL, NULL, NULL, NULL, 'active'),
(186, 32, 66, 'iPhone 16 Pro', 'titan sa mạc', NULL, NULL, NULL, NULL, 'active'),
(187, 32, 67, 'iPhone 16 Pro', 'titan đen', NULL, NULL, NULL, NULL, 'active'),
(188, 31, 2, 'Samsung Galaxy S22 Ultra', 'đỏ', NULL, NULL, NULL, NULL, 'active'),
(189, 31, 4, 'Samsung Galaxy S22 Ultra', 'đen', NULL, NULL, NULL, NULL, 'active'),
(190, 31, 5, 'Samsung Galaxy S22 Ultra', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(191, 31, 7, 'Samsung Galaxy S22 Ultra', 'xanh lục', NULL, NULL, NULL, NULL, 'active'),
(192, 30, 3, 'samsung s25 ultra', 'xanh dương', NULL, NULL, NULL, NULL, 'active'),
(193, 30, 4, 'samsung s25 ultra', 'đen', NULL, NULL, NULL, NULL, 'active'),
(194, 30, 5, 'samsung s25 ultra', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(195, 30, 56, 'samsung s25 ultra', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(196, 27, 4, 'samsung s24', 'đen', NULL, NULL, NULL, NULL, 'active'),
(197, 29, 6, 'OPPO Reno10 Pro', 'xám', NULL, NULL, NULL, NULL, 'active'),
(198, 29, 68, 'OPPO Reno10 Pro', 'tím', NULL, NULL, NULL, NULL, 'active'),
(199, 29, 70, 'OPPO Reno10 Pro', 'cam', NULL, NULL, NULL, NULL, 'active'),
(200, 35, 4, 'Samsung A56', 'đen', NULL, NULL, NULL, NULL, 'active'),
(201, 35, 5, 'Samsung A56', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(202, 35, 6, 'Samsung A56', 'xám', NULL, NULL, NULL, NULL, 'active'),
(203, 35, 56, 'Samsung A56', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(204, 35, 59, 'Samsung A56', 'zenvn', NULL, NULL, NULL, NULL, 'active'),
(205, 35, 71, 'Samsung A56', 'hồng', NULL, NULL, NULL, NULL, 'active'),
(206, 27, 6, 'samsung s24', 'xám', NULL, NULL, NULL, NULL, 'active'),
(207, 27, 68, 'samsung s24', 'tím', NULL, NULL, NULL, NULL, 'active'),
(208, 36, 3, 'oppo find x8 pro', 'xanh dương', NULL, NULL, NULL, NULL, 'active'),
(209, 36, 4, 'oppo find x8 pro', 'đen', NULL, NULL, NULL, NULL, 'active'),
(210, 36, 5, 'oppo find x8 pro', 'trắng/bạc', NULL, NULL, NULL, NULL, 'active'),
(211, 36, 56, 'oppo find x8 pro', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(212, 36, 57, 'oppo find x8 pro', '256 GB', NULL, NULL, NULL, NULL, 'active'),
(213, 36, 59, 'oppo find x8 pro', 'zenvn', NULL, NULL, NULL, NULL, 'active'),
(214, 37, 4, 'Điện thoại Oppo Reno12f', 'đen', NULL, NULL, NULL, NULL, 'active'),
(215, 37, 7, 'Điện thoại Oppo Reno12f', 'xanh lục', NULL, NULL, NULL, NULL, 'active'),
(216, 37, 70, 'Điện thoại Oppo Reno12f', 'cam', NULL, NULL, NULL, NULL, 'active'),
(217, 37, 56, 'Điện thoại Oppo Reno12f', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(218, 38, 3, 'oppo a58', 'xanh dương', NULL, NULL, NULL, NULL, 'active'),
(219, 38, 4, 'oppo a58', 'đen', NULL, NULL, NULL, NULL, 'active'),
(220, 38, 56, 'oppo a58', '128 GB', NULL, NULL, NULL, NULL, 'active'),
(221, 38, 57, 'oppo a58', '256 GB', NULL, NULL, NULL, NULL, 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'founder', 'web', '2025-02-26 13:01:30', '2025-02-26 13:01:30'),
(2, 'admin', 'web', '2025-02-26 13:01:30', '2025-02-26 13:01:30'),
(3, 'member', 'web', '2025-02-26 13:36:08', '2025-02-26 13:36:08'),
(4, 'guest', 'web', '2025-02-26 13:36:08', '2025-02-26 13:36:08'),
(16, 'test01', 'web', '2025-03-10 17:00:00', NULL);

--
-- Bẫy `roles`
--
DELIMITER $$
CREATE TRIGGER `before_delete_role` BEFORE DELETE ON `roles` FOR EACH ROW DELETE FROM role_has_permissions WHERE role_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_name` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`, `permission_name`, `role_name`) VALUES
(11, 2, 'delete-user', 'admin'),
(16, 2, 'access-user', 'admin'),
(17, 2, 'create-user', 'admin'),
(18, 2, 'edit-user', 'admin');

--
-- Bẫy `role_has_permissions`
--
DELIMITER $$
CREATE TRIGGER `before_insert_role_has_permissions` BEFORE INSERT ON `role_has_permissions` FOR EACH ROW BEGIN
    DECLARE perm_name VARCHAR(255);
    DECLARE role_name VARCHAR(255);

    -- Lấy tên quyền từ bảng permissions
    SELECT name INTO perm_name FROM permissions WHERE id = NEW.permission_id;

    -- Lấy tên vai trò từ bảng roles
    SELECT name INTO role_name FROM roles WHERE id = NEW.role_id;

    -- Gán giá trị vào NEW trước khi INSERT
    SET NEW.permission_name = perm_name;
    SET NEW.role_name = role_name;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rss`
--

CREATE TABLE `rss` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `source` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `rss`
--

INSERT INTO `rss` (`id`, `name`, `status`, `link`, `ordering`, `source`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Thế giới - vnexpress', 'active', 'https://vnexpress.net/rss/the-gioi.rss', 12, 'vnexpress', '2023-12-25 07:05:36', 'phamdat', '2025-04-29 00:00:00', 'admin'),
(3, 'Sức khỏe - vnexpress', 'inactive', 'https://vnexpress.net/rss/suc-khoe.rss', 9, 'vnexpress', '2023-12-25 07:05:36', 'phamdat', '2024-07-02 00:00:00', 'admin'),
(6, 'Số hóa - vnexpress', 'inactive', 'https://vnexpress.net/rss/so-hoa.rss', 22, 'vnexpress', '2023-12-25 00:00:00', 'admin', '2024-07-02 00:00:00', 'dat123'),
(7, 'Thể Thao - vnexpress', 'inactive', 'https://vnexpress.net/rss/the-thao.rss', 10, 'vnexpress', '2023-12-27 00:00:00', 'admin', '2024-07-02 00:00:00', 'dat123'),
(8, 'Thời sự - thanhnien', 'inactive', 'https://thanhnien.vn/rss/thoi-su.rss', 5, 'thanhnien', '2023-12-27 00:00:00', 'admin', '2024-07-02 00:00:00', 'admin'),
(9, 'Nhịp sống số - tuoitre', 'inactive', 'https://tuoitre.vn/rss/nhip-song-so.rss', 1, 'tuoitre', '2023-12-27 00:00:00', 'admin', '2025-04-29 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rssnews`
--

CREATE TABLE `rssnews` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pubDate` datetime DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `domain` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rssnews`
--

INSERT INTO `rssnews` (`id`, `title`, `description`, `pubDate`, `link`, `thumb`, `created_by`, `status`, `domain`) VALUES
(14479, 'Thẩm phán tiếp tục chặn lệnh cấm Harvard tuyển du học sinh', 'Thẩm phán liên bang ở Massachusetts cho phép Harvard tiếp tục tuyển du học sinh trong thời gian chờ xử lý vụ kiện giữa trường với chính quyền ông Trump.', '2025-05-30 08:35:55', 'https://vnexpress.net/tham-phan-tiep-tuc-chan-lenh-cam-harvard-tuyen-du-hoc-sinh-4892262.html', 'https://i1-vnexpress.vnecdn.net/2025/05/30/afp-20250422-aa-22042025-21897-8140-8061-1748566334.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=AikKk7AsXUIgXKKXS2yOpA', 'VNExpress', 'active', 'vnexpress'),
(14480, 'Mỹ nói Israel chấp nhận đề xuất ngừng bắn ở Gaza', 'Nhà Trắng thông báo đã gửi cho Hamas đề xuất ngừng bắn được Israel chấp thuận, nhóm vũ trang cho biết đang nghiên cứu cách phản hồi.', '2025-05-30 07:51:00', 'https://vnexpress.net/my-noi-israel-chap-nhan-de-xuat-ngung-ban-o-gaza-4892264.html', 'https://i1-vnexpress.vnecdn.net/2025/05/30/Israel-1748564483-2719-1748564675.png?w=1200&h=0&q=100&dpr=1&fit=crop&s=uOwi2BD9hwshPEC0rbmVWQ', 'VNExpress', 'active', 'vnexpress'),
(14481, 'Ukraine yêu cầu Nga cung cấp dự thảo điều kiện ngừng bắn', 'Ukraine nói sẵn sàng tiếp tục hòa đàm ở Istanbul như Nga đề nghị, song nhấn mạnh Moskva phải cung cấp tài liệu nêu rõ các điều kiện hòa bình.', '2025-05-30 06:57:56', 'https://vnexpress.net/ukraine-yeu-cau-nga-cung-cap-du-thao-dieu-kien-ngung-ban-4892255.html', 'https://i1-vnexpress.vnecdn.net/2025/05/30/Ukraine1-1748561823-3618-1748561869.png?w=1200&h=0&q=100&dpr=1&fit=crop&s=IU9Dc4DPCBXI1Ht_jJIeAw', 'VNExpress', 'active', 'vnexpress'),
(14482, 'Anh công bố danh tính nghi phạm lao xe vào đám đông CĐV Liverpool', 'Nghi phạm trong vụ lao xe vào đám đông CĐV Liverpool được xác định là Paul Doyle, cựu đặc nhiệm thủy quân lục chiến Anh.', '2025-05-30 06:36:42', 'https://vnexpress.net/anh-cong-bo-danh-tinh-nghi-pham-lao-xe-vao-dam-dong-cdv-liverpool-4892242.html', 'https://i1-vnexpress.vnecdn.net/2025/05/30/telemmglpict000426476559-17485-8050-2629-1748538860.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=S2wSjVDys1TYao7QOch6bQ', 'VNExpress', 'active', 'vnexpress'),
(14483, 'Nhà Trắng cảm ơn Elon Musk', 'Nhà Trắng nói sẽ duy trì nỗ lực tinh giản chính quyền liên bang sau khi Elon Musk rời đi và cảm ơn tỷ phú Mỹ vì sự phục vụ.', '2025-05-30 06:20:52', 'https://vnexpress.net/nha-trang-cam-on-elon-musk-4892248.html', 'https://i1-vnexpress.vnecdn.net/2025/05/30/ap25149626824492-1748559973-4422-1748560151.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=fIlIv0fKU0coHI1gpQp7Ww', 'VNExpress', 'active', 'vnexpress'),
(14484, 'Cú đấm thúc đẩy ông Trump tung đòn với các đại học Mỹ', 'Sau khi nhà hoạt động bảo thủ Hayden William bị đấm tím mắt trước trường UC Berkeley, ông Trump quyết định sẽ tiến hành cuộc chiến chống lại các đại học Mỹ.', '2025-05-30 05:00:00', 'https://vnexpress.net/cu-dam-thuc-day-ong-trump-tung-don-voi-cac-dai-hoc-my-4891786.html', 'https://i1-vnexpress.vnecdn.net/2025/05/29/2019-03-02t000000z-922553217-m-3295-3345-1748496055.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=3hUAKkjLUEjvi_Uno2XbNw', 'VNExpress', 'active', 'vnexpress'),
(14485, 'Những phụ nữ nuôi búp bê \'tái sinh\'', 'Gabi Matos thay tã và âu yếm Ravi như một bà mẹ yêu con, nhưng Ravi không phải là người thật mà là búp bê giống y như trẻ sơ sinh.', '2025-05-30 03:00:00', 'https://vnexpress.net/nhung-phu-nu-nuoi-bup-be-tai-sinh-4892062.html', 'https://i1-vnexpress.vnecdn.net/2025/05/29/download-17-1748510052-2051-17-3563-4948-1748533243.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=xHhglmQcAIuAbWulf6uINA', 'VNExpress', 'active', 'vnexpress'),
(14486, 'Tính năng mẫu ICBM được Mỹ biên chế hơn 50 năm', 'Tên lửa đạn đạo xuyên lục địa Minuteman III, được biên chế từ năm 1970, có thể mang đầu đạn hạt nhân mạnh 475 kiloton và đạt tầm bắn 14.000km.', '2025-05-30 01:00:00', 'https://vnexpress.net/tinh-nang-mau-icbm-duoc-my-bien-che-hon-50-nam-4891931.html', 'https://i1-vnexpress.vnecdn.net/2025/05/29/55631871781372687448a-17484896-3451-9553-1748489671.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=ClGi7qG1aiFV-wWGTjriEw', 'VNExpress', 'active', 'vnexpress'),
(14487, 'Cuộc vượt ngục như \'giữa chốn không người\' làm chấn động nước Mỹ', '10 tù nhân đã vượt ngục thành công khỏi trại giam ở New Orleans và con đường đào thoát của họ bắt đầu ngay phía sau khu vệ sinh.', '2025-05-30 00:00:00', 'https://vnexpress.net/cuoc-vuot-nguc-nhu-giua-chon-khong-nguoi-lam-chan-dong-nuoc-my-4891058.html', 'https://i1-vnexpress.vnecdn.net/2025/05/27/edited-8b12ddd5-fca5-42e3-94bd-8888-1555-1748345109.jpg?w=1200&h=0&q=100&dpr=1&fit=crop&s=-2plCCUbHUOe5lrbxJvaZw', 'VNExpress', 'active', 'vnexpress');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `setting`
--

INSERT INTO `setting` (`id`, `key_value`, `value`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'setting-general', '{\"logo\":\"\\/images\\/logo\\/logo-topmargin.JPG\",\"hotline\":\"123456789123\",\"timeword\":\"124\\/124\",\"copyright\":\"@2020 - B\\u1ea3n quy\\u1ec1n c\\u00f4ng ty l\\u1eadp tr\\u00ecnh Zendvn\",\"address\":\"S\\u1ed1 01, Kh\\u1ed1i A1, To\\u00e0 nh\\u00e0 \\u0110\\u1ea1t Gia, 43 \\u0110\\u01b0\\u1eddng C\\u00e2y Keo, Tam Ph\\u00fa, Th\\u1ee7 \\u0110\\u1ee9c, H\\u1ed3 Ch\\u00ed Minh\",\"introduction\":\"<p>C&ocirc;ng Ty C\\u1ed5 Ph\\u1ea7n L\\u1eadp Tr&igrave;nh Zend Vi\\u1ec7t Nam - M&atilde; s\\u1ed1 thu\\u1ebf: 0314390745. Gi\\u1ea5y ph&eacute;p \\u0111\\u0103ng k&yacute; kinh doanh s\\u1ed1 0314390745 do S\\u1edf K\\u1ebf ho\\u1ea1ch v&agrave; \\u0110\\u1ea7u t\\u01b0 Th&agrave;nh ph\\u1ed1 H\\u1ed3 Ch&iacute; Minh c\\u1ea5p ng&agrave;y 09\\/05\\/2017<\\/p>\",\"googlemap\":\"<iframe src=\\\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d3918.3604198520575!2d106.73612927408858!3d10.86016745764545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527d5640014e7%3A0x3bb323b29d50dca9!2zWmVuZFZOIC0gxJDDoG8gVOG6oW8gTOG6rXAgVHLDrG5oIFZpw6pu!5e0!3m2!1svi!2s!4v1721455847550!5m2!1svi!2s\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"><\\/iframe>\",\"taskGeneral\":\"Save\"}', 'active', '2024-07-20 14:33:27', 'Admin', '2024-07-23 00:00:00', 'admin'),
(2, 'setting-email', '{\"username\":\"phamdat999666@gmail.com\",\"password\":\"phnfqmrkrrcawnhq\",\"bcc\":\"phamdat9966@gmail.com,phamdinh01011945@gmail.com\",\"taskEmailAccount\":\"Save\"}', 'active', '2024-07-20 14:33:27', 'Admin', '2024-07-23 00:00:00', 'admin'),
(3, 'setting-social', '{\"facebook\":\"https:\\/\\/www.facebook.com\\/zendvngroup12345\",\"youtube\":\"https:\\/\\/www.youtube.com\\/user\\/zendvn\",\"google\":\"https:\\/\\/www.youtube.com\\/user\\/zendvn\"}', 'active', '2024-07-20 14:33:27', 'Admin', '2024-07-23 00:00:00', 'admin'),
(4, 'setting-video', 'https://www.youtube.com/watch?v=vo1XjuLVaZo&list=PLv6GftO355AsZFXlWLKob6tMsWZa4VCY1', 'active', '2024-07-20 14:33:27', 'Admin', '2024-07-23 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `status` varchar(225) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `shipping`
--

INSERT INTO `shipping` (`id`, `name`, `cost`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Hồ Chí Minh', 30000, 'active', 1, '2024-12-19 13:18:21', 'admin', NULL, NULL),
(2, 'Cần thơ', 50000, 'active', NULL, '2024-12-19 00:00:00', 'admin', '2024-12-19 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider`
--

CREATE TABLE `slider` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `thumb` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `slider`
--

INSERT INTO `slider` (`id`, `name`, `description`, `link`, `thumb`, `created`, `created_by`, `modified`, `modified_by`, `status`) VALUES
(1, 'Khóa học lập trình Frontend Master', 'Khóa học sẽ giúp bạn trở thành một chuyên gia Frontend với đầy đủ các kiến thức về HTML, CSS, JavaScript, Bootstrap, jQuery, chuyển PSD thành HTML ...', 'https://zendvn.com/khoa-hoc-lap-trinh-frontend-master/', 'rEpDUQCxe4.jpeg', '2024-04-01 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'active'),
(2, 'Học lập trình trực tuyến', 'Học trực tuyến giúp bạn tiết kiệm chi phí, thời gian, cập nhật được nhiều kiến thức mới nhanh nhất và hiệu quả nhất', 'https://zendvn.com/', 'K6B1O6UNCb.jpeg', '2019-04-18 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'inactive'),
(3, 'Ưu đãi học phí', 'Tổng hợp các trương trình ưu đãi học phí hàng tuần, hàng tháng đến tất các các bạn với các mức giảm đặc biệt 50%, 70%,..', 'https://zendvn.com/uu-dai-hoc-phi-tai-zendvn/', 'LWi6hINpXz.jpeg', '2019-04-24 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'active'),
(4, 'Lập trình PHP', 'Khóa học được xây dựng dựa trên kinh nghiệm làm dự án thực tế của ZendVN, ngoài ra khóa học còn sử dụng các tài liệu từ trang Google, stackoverflow.com và các trang web khác.', 'https://zendvn.com/khoa-hoc-lap-trinh-php-chuyen-sau', 'UIFAVEbuoa.jpeg', '2019-04-24 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'active'),
(5, 'Lập trình Laravel', 'Đây là khóa học nâng cao, ZendVN chỉ nhận các bạn học viên đã học xong khóa học Lập trình PHP Offline tại ZendVN; hoặc các bạn đã có làm các project về PHP, MVC, OOP, jQuery AjaxKhóa học Lập trình Laravel sẽ hướng dẫn học viên sử dụng Laravel để xây dựng nhiều loại website khác nhau trong thực tế: doanh nghiệp, tin tức, bán hàng, đa ngôn ngữ.', 'https://zendvn.com/lap-trinh-laravel-offline-off', 'DZeaWRlkPA.png', '2019-04-24 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'active'),
(6, 'Nền tảng & Tư duy lập trình', 'Khóa học Nền tảng & Tư duy lập trình giúp bạn trang bị nền tảng lập trình vững chắc để có thể theo được nghề lập trình và duy trì đam mê với nghề. Các kỹ năng phân tích giải quyết vấn đề, tìm kiếm Google, xử lý lỗi cũng sẽ được hướng dẫn trong khóa học.', 'https://zendvn.com/nen-tang-va-tu-duy-lap-trinh-off', 'ofcAvQCCIQ.png', '2024-07-01 00:00:00', 'hailan', '2025-04-26 00:00:00', 'admin', 'active');

--
-- Bẫy `slider`
--
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterDeleteSlider` AFTER DELETE ON `slider` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount - 1
  WHERE `TableName` = 'slider';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterUpdateSlider` AFTER UPDATE ON `slider` FOR EACH ROW BEGIN
  -- Assuming that the primary key of the article table is 'id'
  IF NEW.id <> OLD.id THEN
    UPDATE `totalelements`
    SET ElementCount = ElementCount + 1
    WHERE `TableName` = 'slider';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsSlider` AFTER INSERT ON `slider` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount + 1
  WHERE `TableName` = 'slider';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider_phone`
--

CREATE TABLE `slider_phone` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `link` varchar(200) NOT NULL,
  `thumb` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `slider_phone`
--

INSERT INTO `slider_phone` (`id`, `name`, `description`, `link`, `thumb`, `created`, `created_by`, `modified`, `modified_by`, `status`) VALUES
(2, 'slider phone 01', 'slider phone 01 Description', 'https://zendvn.com/', 'S6XBhPvz6x.png', '2025-05-30 00:00:00', 'admin', '2025-07-18 00:00:00', 'admin', 'active'),
(3, 'slider phone 02', 'slider phone 02 Description', 'https://zendvn.com/', 'PC5AdOR16k.png', '2025-06-02 00:00:00', 'admin', '2025-06-02 00:00:00', 'admin', 'active'),
(4, 'slider phone 03', 'slider phone 03 Description', 'https://zendvn.com/', 'oSzdEBVLqa.png', '2025-06-02 00:00:00', 'admin', '2025-06-02 00:00:00', 'admin', 'active');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider_translations`
--

CREATE TABLE `slider_translations` (
  `id` int(20) UNSIGNED NOT NULL,
  `slider_id` int(11) UNSIGNED NOT NULL,
  `locale` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slider_translations`
--

INSERT INTO `slider_translations` (`id`, `slider_id`, `locale`, `name`, `description`) VALUES
(3, 6, 'vi', 'Nền tảng & Tư duy lập trình', 'Khóa học Nền tảng & Tư duy lập trình giúp bạn trang bị nền tảng lập trình vững chắc để có thể theo được nghề lập trình và duy trì đam mê với nghề. Các kỹ năng phân tích giải quyết vấn đề, tìm kiếm Google, xử lý lỗi cũng sẽ được hướng dẫn trong khóa học.'),
(4, 6, 'en', 'Programming Foundations and Mindset', 'The Programming Foundation & Thinking course helps you equip yourself with a solid programming foundation so you can pursue a programming career and maintain your passion for the profession. Problem-solving analysis skills, Google searches, and error handling will also be taught in the course.'),
(5, 5, 'vi', 'Lập trình Laravel', 'Đây là khóa học nâng cao, ZendVN chỉ nhận các bạn học viên đã học xong khóa học Lập trình PHP Offline tại ZendVN; hoặc các bạn đã có làm các project về PHP, MVC, OOP, jQuery AjaxKhóa học Lập trình Laravel sẽ hướng dẫn học viên sử dụng Laravel để xây dựng nhiều loại website khác nhau trong thực tế: doanh nghiệp, tin tức, bán hàng, đa ngôn ngữ.'),
(6, 5, 'en', 'Laravel Programming', 'This is an advanced course, ZendVN only accepts students who have completed the Offline PHP Programming course at ZendVN; or students who have done projects on PHP, MVC, OOP, jQuery Ajax. The Laravel Programming course will guide students to use Laravel to build many different types of websites in reality: business, news, sales, multilingual.'),
(7, 4, 'vi', 'Lập trình PHP', 'Khóa học được xây dựng dựa trên kinh nghiệm làm dự án thực tế của ZendVN, ngoài ra khóa học còn sử dụng các tài liệu từ trang Google, stackoverflow.com và các trang web khác.'),
(8, 4, 'en', 'PHP Programming', 'The course is built on ZendVN\'s real project experience, and also uses materials from Google, stackoverflow.com and other websites.'),
(9, 3, 'vi', 'Ưu đãi học phí', 'Tổng hợp các trương trình ưu đãi học phí hàng tuần, hàng tháng đến tất các các bạn với các mức giảm đặc biệt 50%, 70%,..'),
(10, 3, 'en', 'Tuition discount', 'Summary of weekly and monthly tuition discount programs for all of you with special discounts of 50%, 70%,..'),
(11, 2, 'vi', 'Học lập trình trực tuyến', 'Học trực tuyến giúp bạn tiết kiệm chi phí, thời gian, cập nhật được nhiều kiến thức mới nhanh nhất và hiệu quả nhất'),
(12, 2, 'en', 'Learn programming online', 'Online learning helps you save money, time, and update new knowledge quickly and effectively.'),
(13, 1, 'vi', 'Khóa học lập trình Frontend Master', 'Khóa học sẽ giúp bạn trở thành một chuyên gia Frontend với đầy đủ các kiến thức về HTML, CSS, JavaScript, Bootstrap, jQuery, chuyển PSD thành HTML ...'),
(14, 1, 'en', 'Frontend Master Programming Course', 'The course will help you become a Frontend expert with full knowledge of HTML, CSS, JavaScript, Bootstrap, jQuery, converting PSD to HTML ...');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `totalelements`
--

CREATE TABLE `totalelements` (
  `TableName` varchar(255) NOT NULL,
  `ElementCount` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `totalelements`
--

INSERT INTO `totalelements` (`TableName`, `ElementCount`, `icon`) VALUES
('article', 22, '<i class=\"fa fa-newspaper-o\"></i>'),
('category_article', 20, '<i class=\"fa fa-tasks\"></i>'),
('slider', 6, '<i class=\"fa fa-sliders\"></i>'),
('user', 9, '<i class=\"fa fa-users\"></i>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `status` varchar(10) DEFAULT '0',
  `usually_category` varchar(255) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `avatar`, `created`, `created_by`, `modified`, `modified_by`, `status`, `usually_category`, `roles_id`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123456', 'e10adc3949ba59abbe56e057f20f883e', 'ZnrJ4VWN7s.png', '2024-07-01 00:00:00', 'admin', '2025-02-23 00:00:00', 'admin', 'active', '3,3,3,3,2,2,2,2,2,2,2,2,2,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4', 1),
(2, 'hailan', 'hailan@gmail.com', 'hailan', 'e10adc3949ba59abbe56e057f20f883e', '1eSGmvZ3gM.jpeg', '2014-12-13 07:20:03', 'admin', '2025-02-23 00:00:00', 'admin', 'active', NULL, 1),
(3, 'user123', 'phamdat9966@gmail.com', 'user123', 'e10adc3949ba59abbe56e057f20f883e', 'oZ2drtCZub.jpg', '2019-05-04 00:00:00', 'admin', '2025-07-31 00:00:00', 'admin', 'active', NULL, 2),
(4, 'user456', 'user456@gmail.com', 'user456', 'e10adc3949ba59abbe56e057f20f883e', 'g0r3gYefFo.png', '2019-05-04 00:00:00', 'admin', '2025-08-09 00:00:00', 'admin', 'active', NULL, 2),
(5, 'dat123', 'phamdat999666@gmail.com', 'Dat123', 'e10adc3949ba59abbe56e057f20f883e', 'zpzZTLYNzb.png', '2023-11-28 00:00:00', 'phamdat', '2025-03-14 00:00:00', 'admin', 'active', ',6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,3,3,3,3,2,2,2,3,3,3,2,2,2', 2),
(6, 'phamdat9997778', 'phamdat999999999@gmail.com', 'Phamdat123123213', 'e10adc3949ba59abbe56e057f20f883e', 'pL1DxiUtai.jpg', '2023-11-28 00:00:00', 'phamdat', '2025-03-06 00:00:00', 'user123', 'active', NULL, 4),
(8, 'admin999', 'phamdat999999999663123213216@gmail.com', 'Dat123312321321321', 'e10adc3949ba59abbe56e057f20f883e', '9k04uy61T5.jpg', '2023-11-29 00:00:00', 'phamdat', '2025-02-25 00:00:00', 'admin', 'active', NULL, 2),
(9, 'member0011', 'member999666@gmail.com', 'Member0011', 'e10adc3949ba59abbe56e057f20f883e', 'uajxH2pLAp.jpg', '2023-11-29 00:00:00', 'phamdat', '2025-02-25 00:00:00', 'admin', 'active', NULL, 3),
(15, 'member00111', 'phamdat999666111@gmail.com', 'Member00111', 'e10adc3949ba59abbe56e057f20f883e', 'MxO2Afexqg.png', '2024-01-22 00:00:00', 'admin', '2025-08-09 00:00:00', 'admin', 'active', NULL, 4);

--
-- Bẫy `user`
--
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterDeleteUser` AFTER DELETE ON `user` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount - 1
  WHERE `TableName` = 'user';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsAfterUpdateUser` AFTER UPDATE ON `user` FOR EACH ROW BEGIN
  -- Assuming that the primary key of the article table is 'id'
  IF NEW.id <> OLD.id THEN
    UPDATE `totalelements`
    SET ElementCount = ElementCount + 1
    WHERE `TableName` = 'user';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateTotalElementsUser` AFTER INSERT ON `user` FOR EACH ROW BEGIN
  UPDATE `totalelements`
  SET ElementCount = ElementCount + 1
  WHERE `TableName` = 'user';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_agents`
--

CREATE TABLE `user_agents` (
  `id` int(11) NOT NULL,
  `agent` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timestamps` datetime DEFAULT current_timestamp(),
  `article_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `user_agents`
--

INSERT INTO `user_agents` (`id`, `agent`, `timestamps`, `article_id`) VALUES
(1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:00', NULL),
(2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2025-07-08 02:02:00', NULL),
(3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:00', NULL),
(4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 3),
(5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 4),
(6, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 4),
(7, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 4),
(8, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2025-07-08 02:02:00', 5),
(9, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 5),
(10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 6),
(11, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 6),
(12, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 6),
(13, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2025-07-08 02:02:00', 7),
(14, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 7),
(15, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 11),
(16, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 14),
(17, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 14),
(18, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(19, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(20, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(21, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(22, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(23, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 15),
(24, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 16),
(25, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2025-07-08 02:02:01', 16),
(26, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 16),
(27, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 16),
(28, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 16),
(29, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 16),
(30, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 18),
(31, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 18),
(32, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 18),
(33, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Mobile Safari/537.36', '2025-07-08 02:02:01', 20),
(34, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 20),
(35, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 20),
(36, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 20),
(37, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 20),
(38, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 20),
(39, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(40, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(41, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(42, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(43, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(44, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 21),
(45, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 22),
(46, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 22),
(47, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 22),
(48, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 22),
(49, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 23),
(50, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 23),
(51, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 23),
(52, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 23),
(53, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 23),
(54, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(55, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(56, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(57, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(58, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(59, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 34),
(60, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 35),
(61, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 41),
(62, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 42),
(63, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', '2025-07-08 02:02:01', 42),
(64, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-09 11:24:17', 42),
(65, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-09 11:24:18', 42),
(66, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', '2025-08-09 11:24:19', 42);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `article_translations`
--
ALTER TABLE `article_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_translations_article_id_locale_unique` (`article_id`,`locale`);

--
-- Chỉ mục cho bảng `article_views`
--
ALTER TABLE `article_views`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Chỉ mục cho bảng `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `branch_translations`
--
ALTER TABLE `branch_translations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_article`
--
ALTER TABLE `category_article`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `category_article_translations`
--
ALTER TABLE `category_article_translations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_product_invoice_id` (`invoice_id`);

--
-- Chỉ mục cho bảng `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `attribute_value_id` (`attribute_value_id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_menu_id` (`parent_id`);

--
-- Chỉ mục cho bảng `menusmartphone`
--
ALTER TABLE `menusmartphone`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_menu_id` (`parent_id`);

--
-- Chỉ mục cho bảng `menu_translations`
--
ALTER TABLE `menu_translations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `phonecontact`
--
ALTER TABLE `phonecontact`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_product_id`);

--
-- Chỉ mục cho bảng `product_attribute_price`
--
ALTER TABLE `product_attribute_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Chỉ mục cho bảng `product_has_attribute`
--
ALTER TABLE `product_has_attribute`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_has_attribute_index_0` (`product_id`,`attribute_value_id`),
  ADD KEY `attribute_value_id` (`attribute_value_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `rss`
--
ALTER TABLE `rss`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `rssnews`
--
ALTER TABLE `rssnews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`key_value`);

--
-- Chỉ mục cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `slider_phone`
--
ALTER TABLE `slider_phone`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `slider_translations`
--
ALTER TABLE `slider_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_slider_translations_slider` (`slider_id`);

--
-- Chỉ mục cho bảng `totalelements`
--
ALTER TABLE `totalelements`
  ADD PRIMARY KEY (`TableName`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `user_agents`
--
ALTER TABLE `user_agents`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `article_translations`
--
ALTER TABLE `article_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `article_views`
--
ALTER TABLE `article_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `attribute_value`
--
ALTER TABLE `attribute_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `branch_translations`
--
ALTER TABLE `branch_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `category_article`
--
ALTER TABLE `category_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `category_article_translations`
--
ALTER TABLE `category_article_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `invoice_product`
--
ALTER TABLE `invoice_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `menusmartphone`
--
ALTER TABLE `menusmartphone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `menu_translations`
--
ALTER TABLE `menu_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `phonecontact`
--
ALTER TABLE `phonecontact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `product_attribute_price`
--
ALTER TABLE `product_attribute_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT cho bảng `product_has_attribute`
--
ALTER TABLE `product_has_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `rss`
--
ALTER TABLE `rss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `rssnews`
--
ALTER TABLE `rssnews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14488;

--
-- AUTO_INCREMENT cho bảng `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `slider_phone`
--
ALTER TABLE `slider_phone`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `slider_translations`
--
ALTER TABLE `slider_translations`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `user_agents`
--
ALTER TABLE `user_agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attribute_value`
--
ALTER TABLE `attribute_value`
  ADD CONSTRAINT `attribute_value_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attribute` (`id`);

--
-- Các ràng buộc cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD CONSTRAINT `fk_invoice_product_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `media_ibfk_2` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_value` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`);

--
-- Các ràng buộc cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `attribute_value` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_details_ibfk_4` FOREIGN KEY (`material_id`) REFERENCES `attribute_value` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_attribute_price`
--
ALTER TABLE `product_attribute_price`
  ADD CONSTRAINT `product_attribute_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_attribute_price_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `attribute_value` (`id`),
  ADD CONSTRAINT `product_attribute_price_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `attribute_value` (`id`);

--
-- Các ràng buộc cho bảng `product_has_attribute`
--
ALTER TABLE `product_has_attribute`
  ADD CONSTRAINT `product_has_attribute_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_has_attribute_ibfk_2` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_value` (`id`);

--
-- Các ràng buộc cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `slider_translations`
--
ALTER TABLE `slider_translations`
  ADD CONSTRAINT `fk_slider_translations_slider` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
