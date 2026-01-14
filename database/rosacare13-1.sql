/*
 Navicat Premium Dump SQL

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 110302 (11.3.2-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : rosacare

 Target Server Type    : MySQL
 Target Server Version : 110302 (11.3.2-MariaDB)
 File Encoding         : 65001

 Date: 13/01/2026 17:10:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for about_translations
-- ----------------------------
DROP TABLE IF EXISTS `about_translations`;
CREATE TABLE `about_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `about_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `story_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `story_paragraphs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `story_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `vision_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vision_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `mission_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mission_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `heritage_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `heritage_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `heritage_subcontent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `why_rosacare_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `benefits_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `about_translations_about_id_locale_unique`(`about_id`, `locale`) USING BTREE,
  INDEX `about_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of about_translations
-- ----------------------------
INSERT INTO `about_translations` VALUES (1, 1, 'ar', 'شاركنا قصتنا', '[\"\\u0631\\u0648\\u0632\\u0627\\u0643\\u064a\\u0631 \\u0647\\u064a \\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 \\u0645\\u062c\\u0631\\u062f \\u0639\\u0644\\u0627\\u0645\\u0629 \\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 - \\u0625\\u0646\\u0647\\u0627 \\u0631\\u062d\\u0644\\u0629 \\u0646\\u062d\\u0648 \\u0627\\u0644\\u0637\\u0628\\u064a\\u0639\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0635\\u0627\\u0644\\u0629. \\u062a\\u0623\\u0633\\u0633\\u062a \\u0645\\u0646 \\u062d\\u0628 \\u0639\\u0645\\u064a\\u0642 \\u0644\\u0644\\u0648\\u0631\\u062f\\u0629 \\u0627\\u0644\\u0634\\u0627\\u0645\\u064a\\u0629 \\u0648\\u062a\\u0642\\u062f\\u064a\\u0631 \\u0644\\u0644\\u062a\\u0631\\u0627\\u062b \\u0627\\u0644\\u0633\\u0648\\u0631\\u064a \\u0627\\u0644\\u0623\\u0635\\u064a\\u0644\\u060c \\u0646\\u0633\\u0639\\u0649 \\u0644\\u0646\\u0642\\u0644 \\u062c\\u0645\\u0627\\u0644 \\u0648\\u0646\\u0642\\u0627\\u0621 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0632\\u0647\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0645\\u064a\\u0632\\u0629 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0639\\u0627\\u0644\\u0645.\",\"\\u0628\\u062f\\u0623\\u062a \\u0631\\u062d\\u0644\\u062a\\u0646\\u0627 \\u0645\\u0646 \\u0642\\u0644\\u0628 \\u0633\\u0648\\u0631\\u064a\\u0627\\u060c \\u062d\\u064a\\u062b \\u062a\\u064f\\u0632\\u0631\\u0639 \\u0623\\u062c\\u0648\\u062f \\u0623\\u0646\\u0648\\u0627\\u0639 \\u0627\\u0644\\u0648\\u0631\\u062f\\u0629 \\u0627\\u0644\\u0634\\u0627\\u0645\\u064a\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0639\\u0627\\u0644\\u0645. \\u0646\\u062d\\u0646 \\u0646\\u0639\\u0645\\u0644 \\u0645\\u0628\\u0627\\u0634\\u0631\\u0629 \\u0645\\u0639 \\u0627\\u0644\\u0645\\u0632\\u0627\\u0631\\u0639\\u064a\\u0646 \\u0627\\u0644\\u0645\\u062d\\u0644\\u064a\\u064a\\u0646 \\u0627\\u0644\\u0630\\u064a\\u0646 \\u064a\\u062d\\u0627\\u0641\\u0638\\u0648\\u0646 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u062a\\u0642\\u0627\\u0644\\u064a\\u062f \\u0627\\u0644\\u0642\\u062f\\u064a\\u0645\\u0629 \\u0641\\u064a \\u0632\\u0631\\u0627\\u0639\\u0629 \\u0648\\u062c\\u0646\\u064a \\u0627\\u0644\\u0648\\u0631\\u062f\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0636\\u0645\\u0646 \\u0623\\u0646 \\u0643\\u0644 \\u0645\\u0646\\u062a\\u062c \\u064a\\u062d\\u0645\\u0644 \\u062c\\u0648\\u0647\\u0631 \\u0627\\u0644\\u0623\\u0635\\u0627\\u0644\\u0629 \\u0648\\u0627\\u0644\\u062c\\u0648\\u062f\\u0629.\"]', 'روزاكير هي أكثر من مجرد علامة تجارية - إنها رحلة نحو الطبيعة والأصالة. تأسست من حب عميق للوردة الشامية وتقدير للتراث السوري الأصيل، نسعى لنقل جمال ونقاء هذه الزهرة المميزة إلى العالم.', 'رؤيتنا', 'أن نكون الرائدين العالميين في تقديم منتجات الوردة الشامية الطبيعية والأصيلة، مع الحفاظ على التراث السوري وتمكين المجتمعات المحلية.', 'مهمتنا', 'تقديم منتجات طبيعية 100% من أعلى جودة، مستخرجة بطرق تقليدية أصيلة، مع الالتزام بالاستدامة والمسؤولية البيئية والاجتماعية.', 'التراث والحرفية', 'تمتد جذورنا إلى قرون من الحرفية السورية التقليدية في استخراج الوردة الشامية. نحن نستخدم الطرق التقليدية الأصيلة التي تم تناقلها عبر الأجيال، مما يضمن الحفاظ على الجودة والنقاء والخصائص الطبيعية الفريدة لهذه الزهرة المميزة.', 'كل قطرة من منتجاتنا تحمل عبق التاريخ والتراث السوري الأصيل. نعتز بهذا الإرث ونسعى للحفاظ عليه وتقديمه للعالم بأعلى معايير الجودة.', 'لماذا روزاكير؟', 'فوائد الوردة الشامية', 'من نحن - روزاكير', 'روزاكير هي علامة تجارية دمشقية تركز على إنشاء منتجات تجميل مستوحاة من الوردة الشامية التقليدية. اكتشف قصتنا ورؤيتنا ومهمتنا.', 'روزاكير، من نحن، الوردة الشامية، التراث السوري، منتجات طبيعية، دمشق، سوريا', '2026-01-13 13:30:23', '2026-01-13 13:43:00');
INSERT INTO `about_translations` VALUES (2, 1, 'en', 'Sharing our story', '[\"RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.\",\"Our journey began from the heart of Syria, where the finest Damask Roses in the world are grown. We work directly with local farmers who preserve ancient traditions in growing and harvesting roses, ensuring that every product carries the essence of authenticity and quality.\"]', 'RosaCare is more than just a brand - it\'s a journey towards nature and authenticity. Founded from a deep love for the Damask Rose and appreciation for authentic Syrian heritage, we strive to bring the beauty and purity of this distinguished flower to the world.', 'Our Vision', 'To be the global leaders in providing natural and authentic Damask Rose products, while preserving Syrian heritage and empowering local communities.', 'Our Mission', 'To deliver 100% natural products of the highest quality, extracted using authentic traditional methods, while committing to sustainability and environmental and social responsibility.', 'Heritage & Craftsmanship', 'Our roots extend to centuries of traditional Syrian craftsmanship in Damask Rose extraction. We use authentic traditional methods passed down through generations, ensuring the preservation of quality, purity, and the unique natural properties of this distinguished flower.', 'Every drop of our products carries the essence of authentic Syrian history and heritage. We cherish this legacy and strive to preserve it and present it to the world with the highest quality standards.', 'Why RosaCare?', 'Benefits of Damask Rose', 'About Us - RosaCare', 'RosaCare is a Damascus-based brand focused on creating beauty products inspired by the traditional Damask Rose. Discover our story, vision, and mission.', 'RosaCare, About Us, Damask Rose, Syrian Heritage, Natural Products, Damascus, Syria', '2026-01-13 13:30:23', '2026-01-13 13:43:00');

-- ----------------------------
-- Table structure for abouts
-- ----------------------------
DROP TABLE IF EXISTS `abouts`;
CREATE TABLE `abouts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hero_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `story_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `story_icon_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vision_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vision_icon_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mission_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mission_icon_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `heritage_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `benefits_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `why_rosacare_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `reasons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `heritage_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of abouts
-- ----------------------------
INSERT INTO `abouts` VALUES (1, 'abouts/hero/01KEVTC2VTVFHAYFDMT6DZMKAZ.webp', 'abouts/story/01KEVTC2VX0ERZ0KGRS7GN52CD.webp', NULL, 'abouts/vision/01KEVSGX1RBN2M690YWNN4K7AE.webp', NULL, NULL, NULL, NULL, NULL, 'abouts/why-rosacare/01KEVSGX1ZVNNQ61XY0CXF3XSY.webp', '[{\"icon_path\":null,\"title\":\"Skin Benefits\",\"description\":\"Deep hydration, skin smoothing, and reduction of wrinkles and fine lines\"},{\"icon_path\":null,\"title\":\"Wellness & Relaxation\",\"description\":\"Natural soothing properties that help with relaxation and stress relief\"},{\"icon_path\":null,\"title\":\"Nutritional Value\",\"description\":\"Rich in vitamins and natural antioxidants beneficial for health\"},{\"icon_path\":null,\"title\":\"100% Natural\",\"description\":\"Pure natural products without chemical additives or preservatives\"}]', '[{\"icon_path\":\"abouts\\/reasons\\/icons\\/01KEVSGX24JAAKWKBSWXFVCPXV.png\",\"title\":\"Natural Ingredients\",\"description\":\"100% natural products extracted from the finest Damask Roses\"},{\"icon_path\":\"abouts\\/reasons\\/icons\\/01KEVSGX26GXD86BW5E2RGH08B.png\",\"title\":\"No Chemicals\",\"description\":\"Completely free from chemicals and synthetic preservatives\"},{\"icon_path\":\"abouts\\/reasons\\/icons\\/01KEVSGX28SJ76Q9Y8794G5NQY.png\",\"title\":\"Trusted Heritage\",\"description\":\"Authentic traditional Syrian methods passed down through generations\"},{\"icon_path\":\"abouts\\/reasons\\/icons\\/01KEVSGX2AXQ0QD1P3GMH81AQM.png\",\"title\":\"Sustainable Practices\",\"description\":\"Commitment to sustainability and environmental responsibility in all our operations\"}]', '[{\"icon_path\":\"abouts\\/heritage\\/icons\\/01KEVSGX2CHPA0ANV6SNC3WN55.png\",\"title\":\"Traditional Extraction\",\"description\":\"Traditional extraction methods preserving all natural properties\"},{\"icon_path\":\"abouts\\/heritage\\/icons\\/01KEVSGX2DP8TYNEJJHJSM8EB4.png\",\"title\":\"Excellence in Quality\",\"description\":\"Commitment to the highest standards of quality and purity in every product\"}]', 1, '2026-01-13 13:30:23', '2026-01-13 13:57:51');

-- ----------------------------
-- Table structure for announcement_translations
-- ----------------------------
DROP TABLE IF EXISTS `announcement_translations`;
CREATE TABLE `announcement_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `announcement_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `announcement_translations_announcement_id_foreign`(`announcement_id`) USING BTREE,
  INDEX `announcement_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of announcement_translations
-- ----------------------------

-- ----------------------------
-- Table structure for announcements
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` date NULL DEFAULT NULL,
  `end_date` date NULL DEFAULT NULL,
  `button_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_text_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of announcements
-- ----------------------------

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('rosadcare-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1768300236;', 1768300236);
INSERT INTO `cache` VALUES ('rosadcare-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:2;', 1768300236);
INSERT INTO `cache` VALUES ('rosadcare-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1768313217;', 1768313217);
INSERT INTO `cache` VALUES ('rosadcare-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1768313217);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_slug_unique`(`slug`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Body Care', 'body-care', NULL, 'categories/images/01KEVFDYDXV6FVQDFJD2T2KV6K.jpg', 1, 1, 1, '2026-01-12 13:45:22', '2026-01-13 10:49:45', NULL);
INSERT INTO `categories` VALUES (2, 'Face Products', 'face-products', NULL, 'categories/images/01KEVEH9EQR5R1V0F31S6KWAJC.jpg', 2, 1, 1, '2026-01-12 13:45:22', '2026-01-13 10:49:26', NULL);
INSERT INTO `categories` VALUES (3, 'Gel Products', 'gel-products', NULL, 'categories/images/01KEV6WPMFZM35JKJFG1N8GCSZ.webp', 3, 1, 1, '2026-01-12 13:45:22', '2026-01-13 10:48:56', NULL);

-- ----------------------------
-- Table structure for category_translations
-- ----------------------------
DROP TABLE IF EXISTS `category_translations`;
CREATE TABLE `category_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `category_translations_category_id_locale_unique`(`category_id`, `locale`) USING BTREE,
  INDEX `category_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category_translations
-- ----------------------------
INSERT INTO `category_translations` VALUES (1, 1, 'en', 'Skincare & Body Care', 'Premium skincare and body care products made from authentic Damask Rose.', 'Damask Rose Skincare & Body Care Products', 'Discover our collection of natural skincare and body care products.', NULL, NULL, NULL);
INSERT INTO `category_translations` VALUES (2, 1, 'ar', 'العناية بالبشرة والجسم', 'منتجات فاخرة للعناية بالبشرة والجسم من الوردة الشامية الأصيلة.', 'منتجات العناية بالبشرة والجسم من الوردة الشامية', 'اكتشف مجموعتنا من منتجات العناية بالبشرة والجسم الطبيعية.', NULL, NULL, NULL);
INSERT INTO `category_translations` VALUES (3, 2, 'en', 'Face Products', 'Gentle, effective face care for every skin type. Our formulas hydrate, protect, and renew your skin for a radiant, healthy glow. Clean, dermatologist-tested, and results-driven.', 'Face Care Products | Clean, Effective Skincare for Radiant Skin', 'Discover our gentle, effective face care line. Hydrate, protect, and renew your skin with clean, dermatologist-tested formulas for a healthy, radiant glow.', 'face wash, moisturizer, serum, sunscreen, cleanser, skincare routine, anti-aging, hydration, ', NULL, NULL);
INSERT INTO `category_translations` VALUES (4, 2, 'ar', 'منتجات الوجه', 'عناية لطيفة وفعَّالة للوجه لكل أنواع البشرة. ترطِّب صيغنا المنتَجة باحترافية بشرتك وتحميها وتجددها لإطلالة مشرقة وصحية. مستحضرات نظيفة، خاضعة لاختبارات أطباء الجلدية وتقدّم نتائج ملموسة.\n\n', 'منتجات العناية بالوجه | مستحضرات عناية نظيفة وفعَّالة لإطلالة مشرقة', 'اكتشفي تشكيلتنا للعناية بالوجه. ترطيب، حماية وتجديد للبشرة بصيغ نظيفة وتم اختبارها من قبل أطباء الجلدية لإطلالة مشرقة وصحية.\n\n', ' مختبر من قبل أطباء الجلدية، عناية يومية بالوجه، تفتيح البشرة، العناية الليلية', NULL, NULL);
INSERT INTO `category_translations` VALUES (5, 3, 'en', 'Gel Products', 'Premium Gel aromatic products for wellness and relaxation.', 'Damask Rose Aromatic Gel Products', 'Discover our gel aromatic products collection.', NULL, NULL, NULL);
INSERT INTO `category_translations` VALUES (6, 3, 'ar', 'منتجات جل', 'منتجات جل عطرية فاخرة للعافية والاسترخاء.', 'منتجات جل عطرية من الوردة الشامية', 'اكتشف مجموعتنا من المنتجات العطرية.', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for contacts
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contacts_is_read_created_at_index`(`is_read`, `created_at`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of contacts
-- ----------------------------
INSERT INTO `contacts` VALUES (1, 'Eiad Darwish', 'eiaddar@gmail.com', '0944408833', 'International Commercial Arbitration Course', 'tedst', 0, NULL, '2026-01-13 10:54:31', '2026-01-13 10:54:31');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for faqs
-- ----------------------------
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `answer` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int NULL DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `faqs_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faqs
-- ----------------------------
INSERT INTO `faqs` VALUES (1, 'ar', 'ما هي منتجات RosaCare؟', 'RosaCare هي علامة متخصصة في تقديم منتجات طبيعية مستخلصة من ورد الجوري الدمشقي، تشمل منتجات العناية بالجمال المصنوعة من زيت الورد وماء الورد الطبيعي.', '2026-01-13 12:44:28', '2026-01-13 12:44:28', 1, 1);
INSERT INTO `faqs` VALUES (2, 'ar', 'هل منتجات RosaCare طبيعية 100%؟', 'نعم، جميع منتجاتنا طبيعية 100%، ومصنوعة من مكونات مختارة بعناية، دون إضافات صناعية ضارة.', '2026-01-13 12:46:51', '2026-01-13 12:46:51', 2, 1);
INSERT INTO `faqs` VALUES (3, 'ar', 'من أين يتم الحصول على ورد الجوري المستخدم في المنتجات؟', 'نحصل على ورد الجوري من مزارع مختارة في سوريا، حيث يُزرع ويُقطف وفق تقاليد زراعية عريقة متوارثة منذ قرون.', '2026-01-13 12:47:07', '2026-01-13 12:47:07', 3, 1);
INSERT INTO `faqs` VALUES (4, 'ar', 'كيف يتم استخلاص زيت وماء الورد؟', 'يتم الاستخلاص باستخدام طرق تقليدية أصيلة تحافظ على نقاء المكونات وخصائصها الطبيعية، دون الإضرار بجودة المنتج.', '2026-01-13 12:47:21', '2026-01-13 12:47:21', 4, 1);
INSERT INTO `faqs` VALUES (5, 'ar', 'هل منتجات RosaCare مناسبة لجميع أنواع البشرة؟', 'نعم، منتجاتنا مناسبة لمعظم أنواع البشرة. ومع ذلك، ننصح دائمًا بإجراء اختبار بسيط على جزء صغير من الجلد قبل الاستخدام.', '2026-01-13 12:47:34', '2026-01-13 12:47:34', 5, 1);
INSERT INTO `faqs` VALUES (6, 'ar', 'هل تقوم RosaCare باختبار منتجاتها على الحيوانات؟', 'لا، نحن نلتزم التزامًا كاملًا بعدم اختبار منتجاتنا على الحيوانات، ونؤمن بجمال أخلاقي ومستدام.', '2026-01-13 12:47:49', '2026-01-13 12:47:49', 6, 1);
INSERT INTO `faqs` VALUES (7, 'ar', 'هل تدعم RosaCare المجتمعات المحلية؟', 'نعم، نعمل بشكل مباشر مع المزارعين المحليين وندعم الحفاظ على التراث الزراعي السوري وتمكين المجتمعات المحلية.', '2026-01-13 12:48:12', '2026-01-13 12:48:12', 7, 1);
INSERT INTO `faqs` VALUES (8, 'ar', 'كيف يمكن التواصل مع فريق RosaCare؟', 'يمكنكم التواصل معنا عبر صفحة اتصل بنا في الموقع، أو من خلال قنوات التواصل الاجتماعي الرسمية.', '2026-01-13 12:48:29', '2026-01-13 12:48:29', 8, 1);
INSERT INTO `faqs` VALUES (9, 'en', 'What products does RosaCare offer?', 'RosaCare specializes in natural beauty products derived from the Damask Rose, including skincare products made from pure rose oil and natural rose water.', '2026-01-13 12:48:46', '2026-01-13 12:48:46', 1, 1);
INSERT INTO `faqs` VALUES (10, 'en', 'Are RosaCare products 100% natural?', 'Yes, all RosaCare products are 100% natural, carefully crafted without harmful synthetic additives.', '2026-01-13 12:49:04', '2026-01-13 12:49:04', 2, 1);
INSERT INTO `faqs` VALUES (11, 'en', 'Where do you source your Damask Roses?', 'Our Damask Roses are sourced from selected farms in Syria, where they are cultivated and harvested using centuries-old traditional methods.', '2026-01-13 12:49:18', '2026-01-13 12:49:18', 3, 1);
INSERT INTO `faqs` VALUES (12, 'en', 'How are the rose oil and rose water extracted?', 'Extraction is carried out using authentic traditional techniques that preserve the purity and natural properties of the rose.', '2026-01-13 12:49:31', '2026-01-13 13:15:40', 4, 1);
INSERT INTO `faqs` VALUES (13, 'en', 'Are RosaCare products suitable for all skin types?', 'Yes, our products are suitable for most skin types. However, we recommend performing a patch test before regular use.', '2026-01-13 12:49:46', '2026-01-13 12:49:46', 5, 1);
INSERT INTO `faqs` VALUES (14, 'en', 'Does RosaCare test its products on animals?', 'No, RosaCare is firmly committed to cruelty-free practices and does not test any of its products on animals.', '2026-01-13 12:50:07', '2026-01-13 13:14:39', 6, 1);
INSERT INTO `faqs` VALUES (15, 'en', 'Does RosaCare support local communities?', 'Yes, we work closely with local farmers and actively support the preservation of Syrian agricultural heritage and local communities.', '2026-01-13 12:50:21', '2026-01-13 13:14:48', 7, 1);
INSERT INTO `faqs` VALUES (16, 'en', 'How can I contact RosaCare?', 'You can reach us through the Contact Us page on our website or via our official social media channels.', '2026-01-13 12:50:38', '2026-01-13 13:14:55', 8, 1);

-- ----------------------------
-- Table structure for heroes
-- ----------------------------
DROP TABLE IF EXISTS `heroes`;
CREATE TABLE `heroes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of heroes
-- ----------------------------
INSERT INTO `heroes` VALUES (1, 'heroes/images/01KEV67FRFX84TT91RJVGTC005.webp', 'https://rosacare.sy/products', '#862b90', '#ffffff', 1, '2026-01-13 08:05:30', '2026-01-13 08:05:49');
INSERT INTO `heroes` VALUES (2, 'heroes/images/01KEV6CF1X5MZK5HQJQJWT0K3F.webp', 'http://rosacare.test/products', '#e72177', '#ffffff', 1, '2026-01-13 08:08:32', '2026-01-13 08:08:32');

-- ----------------------------
-- Table structure for heroes_translations
-- ----------------------------
DROP TABLE IF EXISTS `heroes_translations`;
CREATE TABLE `heroes_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hero_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `hero_translations_unique`(`hero_id`, `locale`) USING BTREE,
  INDEX `heroes_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of heroes_translations
-- ----------------------------
INSERT INTO `heroes_translations` VALUES (1, 1, 'ar', 'روزا.د.كير', 'من قلب الشام أرقى منتجات الوردة الشامية', 'اكتشف المزيد', NULL, NULL);
INSERT INTO `heroes_translations` VALUES (2, 1, 'en', 'Rosa.D.Care', 'From the Heart of Damascus, Products for Beauty.', 'Explore Products', NULL, NULL);
INSERT INTO `heroes_translations` VALUES (3, 2, 'ar', ' روزا.د.كير', 'منتجات الوردة الدمشقية بأرقى المواصفات القياسية العالمية', 'اكتشف المزيد', NULL, NULL);
INSERT INTO `heroes_translations` VALUES (4, 2, 'en', 'Rosa.D.Care', 'High Level Standards for Damask Rose Products ', 'Explore Products', NULL, NULL);

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for media
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `collection_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `file_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `size` bigint UNSIGNED NULL DEFAULT NULL,
  `disk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `media_model_type_model_id_index`(`model_type`, `model_id`) USING BTREE,
  INDEX `media_model_type_model_id_collection_name_index`(`model_type`(120), `model_id`, `collection_name`(120)) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of media
-- ----------------------------
INSERT INTO `media` VALUES (8, 'App\\Models\\Product', 2, 'gallery', '01KEVS9R12ZTBBTY4GPP7HWSYE.png', 'image/png', 8479974, 'public', 'products/gallery', 0, NULL, '2026-01-13 13:53:37', '2026-01-13 13:53:37');
INSERT INTO `media` VALUES (9, 'App\\Models\\Product', 2, 'gallery', '01KEVS9R18N1WHK30EH6X7BEHR.png', 'image/png', 1338573, 'public', 'products/gallery', 1, NULL, '2026-01-13 13:53:38', '2026-01-13 13:53:38');
INSERT INTO `media` VALUES (7, 'App\\Models\\Product', 2, 'featured', '01KEVS9R0W5PJNYG500MDNY92G.png', 'image/png', 1338573, 'public', 'products/featured', 0, NULL, '2026-01-13 13:53:37', '2026-01-13 13:53:37');
INSERT INTO `media` VALUES (10, 'App\\Models\\Product', 1, 'featured', '01KEVTVTT9VX81TCDMFC293P3A.png', 'image/png', 2861571, 'public', 'products/featured', 0, NULL, '2026-01-13 14:06:27', '2026-01-13 14:06:27');
INSERT INTO `media` VALUES (11, 'App\\Models\\Product', 1, 'gallery', '01KEVTVTTDRB54XK9BXAVD7815.png', 'image/png', 2878371, 'public', 'products/gallery', 0, NULL, '2026-01-13 14:06:27', '2026-01-13 14:06:27');

-- ----------------------------
-- Table structure for menu_item_translations
-- ----------------------------
DROP TABLE IF EXISTS `menu_item_translations`;
CREATE TABLE `menu_item_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_item_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `menu_item_trans_item_locale_unique`(`menu_item_id`, `locale`) USING BTREE,
  INDEX `menu_item_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu_item_translations
-- ----------------------------

-- ----------------------------
-- Table structure for menu_items
-- ----------------------------
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link',
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `page` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `open_in_new_tab` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `menu_items_category_id_foreign`(`category_id`) USING BTREE,
  INDEX `menu_items_is_active_sort_order_index`(`is_active`, `sort_order`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu_items
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2025_08_26_100418_add_two_factor_columns_to_users_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_12_19_073903_create_categories_table', 1);
INSERT INTO `migrations` VALUES (6, '2025_12_19_073904_create_category_translations_table', 1);
INSERT INTO `migrations` VALUES (7, '2025_12_19_073904_create_products_table', 1);
INSERT INTO `migrations` VALUES (8, '2025_12_19_073906_create_product_translations_table', 1);
INSERT INTO `migrations` VALUES (9, '2025_12_19_073907_create_media_table', 1);
INSERT INTO `migrations` VALUES (10, '2025_12_19_073909_create_contacts_table', 1);
INSERT INTO `migrations` VALUES (11, '2025_12_20_163716_create_navigation_menu_items_table', 1);
INSERT INTO `migrations` VALUES (12, '2025_12_20_163717_create_navigation_menu_item_translations_table', 1);
INSERT INTO `migrations` VALUES (13, '2025_12_22_064238_create_settings_table', 1);
INSERT INTO `migrations` VALUES (14, '2025_12_22_084925_create_pages_table', 1);
INSERT INTO `migrations` VALUES (15, '2025_12_22_092050_create_settings_translations_table', 1);
INSERT INTO `migrations` VALUES (16, '2025_12_22_094313_create_page_translations_table', 1);
INSERT INTO `migrations` VALUES (17, '2025_12_22_104953_rename_settings_translations_to_setting_translations_table', 1);
INSERT INTO `migrations` VALUES (18, '2025_12_30_090624_create_heroes_table', 1);
INSERT INTO `migrations` VALUES (19, '2025_12_30_090624_create_heroes_translations_table', 1);
INSERT INTO `migrations` VALUES (20, '2025_12_30_090633_create_welcomes_table', 1);
INSERT INTO `migrations` VALUES (21, '2025_12_30_090633_create_welcomes_translations_table', 1);
INSERT INTO `migrations` VALUES (22, '2025_12_30_090736_create_welcome_details_table', 1);
INSERT INTO `migrations` VALUES (23, '2025_12_30_090736_create_welcome_details_translations_table', 1);
INSERT INTO `migrations` VALUES (24, '2025_12_30_091022_create_announcements_table', 1);
INSERT INTO `migrations` VALUES (25, '2025_12_30_091022_create_announcements_translations_table', 1);
INSERT INTO `migrations` VALUES (26, '2025_12_30_091212_create_faqs_table', 1);
INSERT INTO `migrations` VALUES (27, '2026_01_11_114419_create_parallaxes_table', 1);
INSERT INTO `migrations` VALUES (28, '2026_01_11_115751_update_parallaxes_table_for_translations', 1);
INSERT INTO `migrations` VALUES (29, '2026_01_13_130459_create_abouts_table', 2);
INSERT INTO `migrations` VALUES (30, '2026_01_13_130740_create_abouts_table', 3);
INSERT INTO `migrations` VALUES (31, '2026_01_13_130800_create_about_translations_table', 3);
INSERT INTO `migrations` VALUES (32, '2026_01_13_131657_enhance_abouts_table_with_images_and_icons', 3);
INSERT INTO `migrations` VALUES (33, '2026_01_13_131713_enhance_about_translations_with_story_paragraphs', 3);

-- ----------------------------
-- Table structure for page_translations
-- ----------------------------
DROP TABLE IF EXISTS `page_translations`;
CREATE TABLE `page_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `page_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `page_translations_page_id_locale_unique`(`page_id`, `locale`) USING BTREE,
  INDEX `page_translations_locale_index`(`locale`) USING BTREE,
  CONSTRAINT `page_trans_content_json_check` CHECK (json_valid(`content`)),
  CONSTRAINT `page_trans_meta_keywords_json_check` CHECK (`meta_keywords` is null or json_valid(`meta_keywords`))
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of page_translations
-- ----------------------------

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `pages_slug_unique`(`slug`) USING BTREE,
  INDEX `pages_slug_index`(`slug`) USING BTREE,
  INDEX `pages_published_index`(`published`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pages
-- ----------------------------

-- ----------------------------
-- Table structure for parallax_translations
-- ----------------------------
DROP TABLE IF EXISTS `parallax_translations`;
CREATE TABLE `parallax_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parallax_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `parallax_translations_parallax_id_locale_unique`(`parallax_id`, `locale`) USING BTREE,
  INDEX `parallax_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parallax_translations
-- ----------------------------
INSERT INTO `parallax_translations` VALUES (1, 1, 'ar', 'من قلب دمشق منتجات الوردة الشامية لجمال اخاذ', 'اكتشف جمالك من خلال منتجات تعكس جمال الوردة الدمشقية ', NULL, NULL);
INSERT INTO `parallax_translations` VALUES (2, 1, 'en', 'Discover the Beauty of Damask Rose', 'Explore our complete collection of premium natural products\n\n', NULL, NULL);

-- ----------------------------
-- Table structure for parallaxes
-- ----------------------------
DROP TABLE IF EXISTS `parallaxes`;
CREATE TABLE `parallaxes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parallaxes
-- ----------------------------
INSERT INTO `parallaxes` VALUES (1, 'parallaxes/images/01KEVN5N9DXWNESZVTCJJQFNRR.png', 'https://rosacare.sy/products', 1, '2026-01-13 12:26:57', '2026-01-13 12:26:57');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product_translations
-- ----------------------------
DROP TABLE IF EXISTS `product_translations`;
CREATE TABLE `product_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `usage_instructions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `meta_keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `product_translations_product_id_locale_unique`(`product_id`, `locale`) USING BTREE,
  INDEX `product_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_translations
-- ----------------------------
INSERT INTO `product_translations` VALUES (1, 1, 'en', 'Damask Rose Water', 'Premium quality Damask Rose Water extracted using traditional methods. Perfect for skincare, aromatherapy, and culinary uses.', 'Pure natural rose water for skincare and wellness.', '[\"100% Pure Damask Rose Water\"]', '[\"Natural moisturizer for all skin types\",\"Soothes and calms irritated skin\",\"Antioxidant properties\",\"Aromatherapy benefits\"]', '[\"Apply directly to face as toner\",\"Use as facial mist throughout the day\",\"Add to bath water for relaxation\"]', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product_translations` VALUES (2, 1, 'ar', 'ماء الورد الشامي', 'ماء الورد الشامي عالي الجودة المستخرج بطرق تقليدية. مثالي للعناية بالبشرة والعلاج بالعطور والاستخدامات الطهي.', 'ماء ورد طبيعي خالص للعناية بالبشرة والعافية.', '[\"100% \\u0645\\u0627\\u0621 \\u0648\\u0631\\u062f \\u0634\\u0627\\u0645\\u064a \\u062e\\u0627\\u0644\\u0635\"]', '[\"\\u0645\\u0631\\u0637\\u0628 \\u0637\\u0628\\u064a\\u0639\\u064a \\u0644\\u062c\\u0645\\u064a\\u0639 \\u0623\\u0646\\u0648\\u0627\\u0639 \\u0627\\u0644\\u0628\\u0634\\u0631\\u0629\",\"\\u064a\\u0647\\u062f\\u0626 \\u0648\\u064a\\u0644\\u0637\\u0641 \\u0627\\u0644\\u0628\\u0634\\u0631\\u0629 \\u0627\\u0644\\u0645\\u062a\\u0647\\u064a\\u062c\\u0629\",\"\\u062e\\u0635\\u0627\\u0626\\u0635 \\u0645\\u0636\\u0627\\u062f\\u0629 \\u0644\\u0644\\u0623\\u0643\\u0633\\u062f\\u0629\",\"\\u0641\\u0648\\u0627\\u0626\\u062f \\u0627\\u0644\\u0639\\u0644\\u0627\\u062c \\u0628\\u0627\\u0644\\u0639\\u0637\\u0648\\u0631\"]', '[\"\\u0636\\u0639 \\u0645\\u0628\\u0627\\u0634\\u0631\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0648\\u062c\\u0647 \\u0643\\u062a\\u0648\\u0646\\u0631\",\"\\u0627\\u0633\\u062a\\u062e\\u062f\\u0645 \\u0643\\u0628\\u062e\\u0627\\u062e \\u0644\\u0644\\u0648\\u062c\\u0647 \\u062e\\u0644\\u0627\\u0644 \\u0627\\u0644\\u0646\\u0647\\u0627\\u0631\",\"\\u0623\\u0636\\u0641 \\u0625\\u0644\\u0649 \\u0645\\u0627\\u0621 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062d\\u0645\\u0627\\u0645 \\u0644\\u0644\\u0627\\u0633\\u062a\\u0631\\u062e\\u0627\\u0621\"]', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product_translations` VALUES (3, 2, 'en', 'RosaCare Eye Contour Gel', 'RosaCare Eye Contour Gel is a lightweight, fast-absorbing formula designed to refresh, illuminate, and restore the delicate skin around the eyes. Infused with the purity of Damask Rose extracts, this advanced gel helps reduce the appearance of dark circles, puffiness, and signs of fatigue, revealing a smoother, brighter, and more youthful eye contour.\n\nInspired by nature and perfected through gentle formulation, RosaCare Eye Contour Gel delivers hydration and comfort without heaviness, making it ideal for daily use and suitable for all skin types.', 'RosaCare Eye Contour Gel', '[\"Damask Rose Water\",\"Damask Rose Oil\",\"Aloe Vera Extract\",\"Vitamin E\"]', '[\"Visibly reduces the appearance of dark circles\",\"Helps diminish puffiness and signs of fatigue\",\"Deeply hydrates and refreshes the eye contour\",\"Improves skin smoothness and elasticity\",\"Brightens and revitalizes tired-looking eyes\",\"Lightweight, non-greasy, and fast-absorbing\",\"Suitable for all skin types, including sensitive skin\"]', '[\"Apply a small amount to clean skin around the eye area\",\" Gently tap with your fingertips until fully absorbed\",\"Use morning and evening for best results.\"]', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `product_translations` VALUES (4, 2, 'ar', 'مصحّح الهالات السوداء ومنعش محيط العين', 'جل محيط العين من RosaCare هو تركيبة خفيفة وسريعة الامتصاص، صُممت خصيصًا للعناية بالبشرة الرقيقة حول العينين. غني بمستخلصات ورد الجوري الدمشقي النقي، يساعد هذا الجل على تقليل مظهر الهالات السوداء والانتفاخ وعلامات الإرهاق، ليمنح العينين مظهرًا أكثر إشراقًا وحيوية.\n\nمستوحى من الطبيعة ومطوّر بتركيبة لطيفة، يوفّر جل محيط العين ترطيبًا عميقًا وإحساسًا بالراحة دون أي ثقل، مما يجعله مثاليًا للاستخدام اليومي ومناسبًا لجميع أنواع البشرة، بما فيها الحساسة.', 'مستوحى من الطبيعة ومطوّر بتركيبة لطيفة، يوفّر جل محيط العين ترطيبًا عميقًا وإحساسًا بالراحة دون أي ثقل، مما يجعله مثاليًا للاستخدام اليومي ومناسبًا لجميع أنواع البشرة، بما فيها الحساسة.', '[\"\\u0645\\u0627\\u0621 \\u0648\\u0631\\u062f \\u0627\\u0644\\u062c\\u0648\\u0631\\u064a \\u0627\\u0644\\u062f\\u0645\\u0634\\u0642\\u064a\",\"\\u0632\\u064a\\u062a \\u0648\\u0631\\u062f \\u0627\\u0644\\u062c\\u0648\\u0631\\u064a \\u0627\\u0644\\u062f\\u0645\\u0634\\u0642\\u064a\",\"\\u0645\\u0633\\u062a\\u062e\\u0644\\u0635 \\u0627\\u0644\\u0643\\u0627\\u0641\\u064a\\u064a\\u0646\",\"\\u0641\\u064a\\u062a\\u0627\\u0645\\u064a\\u0646 E\",\"\\u0645\\u0633\\u062a\\u062e\\u0644\\u0635 \\u0627\\u0644\\u0623\\u0644\\u0648\\u0641\\u064a\\u0631\\u0627 (\\u0627\\u0644\\u0635\\u0628\\u0627\\u0631)\"]', '[\"\\u064a\\u0642\\u0644\\u0644 \\u0645\\u0646 \\u0645\\u0638\\u0647\\u0631 \\u0627\\u0644\\u0647\\u0627\\u0644\\u0627\\u062a \\u0627\\u0644\\u0633\\u0648\\u062f\\u0627\\u0621 \\u0628\\u0634\\u0643\\u0644 \\u0645\\u0644\\u062d\\u0648\\u0638\",\"\\u064a\\u062e\\u0641\\u0641 \\u0627\\u0644\\u0627\\u0646\\u062a\\u0641\\u0627\\u062e \\u0648\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u062a\\u0639\\u0628 \\u062d\\u0648\\u0644 \\u0627\\u0644\\u0639\\u064a\\u0646\",\"\\u064a\\u0645\\u0646\\u062d \\u062a\\u0631\\u0637\\u064a\\u0628\\u064b\\u0627 \\u0639\\u0645\\u064a\\u0642\\u064b\\u0627 \\u0648\\u0627\\u0646\\u062a\\u0639\\u0627\\u0634\\u064b\\u0627 \\u0641\\u0648\\u0631\\u064a\\u064b\\u0627\",\"\\u064a\\u062d\\u0633\\u0651\\u0646 \\u0646\\u0639\\u0648\\u0645\\u0629 \\u0648\\u0645\\u0631\\u0648\\u0646\\u0629 \\u0627\\u0644\\u0628\\u0634\\u0631\\u0629\",\"\\u064a\\u0639\\u064a\\u062f \\u0627\\u0644\\u0625\\u0634\\u0631\\u0627\\u0642\\u0629 \\u0648\\u0627\\u0644\\u062d\\u064a\\u0648\\u064a\\u0629 \\u0644\\u0645\\u062d\\u064a\\u0637 \\u0627\\u0644\\u0639\\u064a\\u0646\",\"\\u062a\\u0631\\u0643\\u064a\\u0628\\u0629 \\u062e\\u0641\\u064a\\u0641\\u0629 \\u063a\\u064a\\u0631 \\u062f\\u0647\\u0646\\u064a\\u0629 \\u0648\\u0633\\u0631\\u064a\\u0639\\u0629 \\u0627\\u0644\\u0627\\u0645\\u062a\\u0635\\u0627\\u0635\",\"\\u0645\\u0646\\u0627\\u0633\\u0628 \\u0644\\u062c\\u0645\\u064a\\u0639 \\u0623\\u0646\\u0648\\u0627\\u0639 \\u0627\\u0644\\u0628\\u0634\\u0631\\u0629\\u060c \\u0628\\u0645\\u0627 \\u0641\\u064a\\u0647\\u0627 \\u0627\\u0644\\u062d\\u0633\\u0627\\u0633\\u0629\"]', '[\"\\u064a\\u0648\\u0636\\u0639 \\u0645\\u0642\\u062f\\u0627\\u0631 \\u0635\\u063a\\u064a\\u0631 \\u0639\\u0644\\u0649 \\u0628\\u0634\\u0631\\u0629 \\u0646\\u0638\\u064a\\u0641\\u0629 \\u062d\\u0648\\u0644 \\u0627\\u0644\\u0639\\u064a\\u0646\",\"\\u0645\\u0639 \\u0627\\u0644\\u062a\\u0631\\u0628\\u064a\\u062a \\u0628\\u0644\\u0637\\u0641 \\u0628\\u0623\\u0637\\u0631\\u0627\\u0641 \\u0627\\u0644\\u0623\\u0635\\u0627\\u0628\\u0639 \\u062d\\u062a\\u0649 \\u0627\\u0644\\u0627\\u0645\\u062a\\u0635\\u0627\\u0635 \\u0627\\u0644\\u0643\\u0627\\u0645\\u0644\",\"\\u064a\\u064f\\u0633\\u062a\\u062e\\u062f\\u0645 \\u0635\\u0628\\u0627\\u062d\\u064b\\u0627 \\u0648\\u0645\\u0633\\u0627\\u0621\\u064b \\u0644\\u0644\\u062d\\u0635\\u0648\\u0644 \\u0639\\u0644\\u0649 \\u0623\\u0641\\u0636\\u0644 \\u0627\\u0644\\u0646\\u062a\\u0627\\u0626\\u062c.\"]', NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `sale_price` decimal(10, 2) NULL DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT 0,
  `in_stock` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int NOT NULL DEFAULT 0,
  `view_count` int NOT NULL DEFAULT 0,
  `specifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `products_slug_unique`(`slug`) USING BTREE,
  UNIQUE INDEX `products_sku_unique`(`sku`) USING BTREE,
  INDEX `products_category_id_is_active_index`(`category_id`, `is_active`) USING BTREE,
  INDEX `products_is_featured_is_active_index`(`is_featured`, `is_active`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 2, NULL, NULL, 'damask-rose-water', 29.99, NULL, 0, 1, 1, 1, 1, 2, NULL, '2026-01-12 13:45:22', '2026-01-13 14:06:27', NULL);
INSERT INTO `products` VALUES (2, 2, NULL, 'RDC-2236-65', 'damask-rose-jam', 24.99, 20.99, 0, 1, 1, 1, 1, 7, NULL, '2026-01-12 13:45:22', '2026-01-13 14:06:43', NULL);

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id`) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('nJQrqE6XuljGdCT80Q1YJgpjPX4znNx0BqDj1ro9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiaXk1NlRDV0ExakZmZ3d2UlA1Z1hvY1ROWHBDTHZMZ1NQalBTTHFSbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6Ijk5YTBmYThkYjQ2Njg2MmExN2JkOGFiNWNlODRjMmYzMDkxZmUwMTZmOGViNjRmMDUzMGZkYjhjZGJkNzYwNGYiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6NjoidGFibGVzIjthOjg6e3M6NDA6ImRkYzFkMDhlYmVmYTY1MjI5MDNhYjFmMzdjM2NiOGFjX2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InRpdGxlIjtzOjU6ImxhYmVsIjtzOjU6IlRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJpbWFnZSI7czo1OiJsYWJlbCI7czo1OiJJbWFnZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InNvcnRfb3JkZXIiO3M6NToibGFiZWwiO3M6MTA6IlNvcnQgb3JkZXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImlzX2FjdGl2ZSI7czo1OiJsYWJlbCI7czo5OiJJcyBhY3RpdmUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjExOiJpc19mZWF0dXJlZCI7czo1OiJsYWJlbCI7czoxMToiSXMgZmVhdHVyZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJkZWxldGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJEZWxldGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6Ijk3OTJiNmRlNTczMTU2ZWMwNDVlYTgxODgxYmUzZDNkX2NvbHVtbnMiO2E6NTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6InNsdWciO3M6NToibGFiZWwiO3M6NDoiU2x1ZyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTc6ImhlYWRlcl9pbWFnZV9wYXRoIjtzOjU6ImxhYmVsIjtzOjE3OiJIZWFkZXIgaW1hZ2UgcGF0aCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToicHVibGlzaGVkIjtzOjU6ImxhYmVsIjtzOjk6IlB1Ymxpc2hlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkNyZWF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiOGZhYzZlYjFjZWMyNjgwM2IzZjdmYjQ0MGEyNzExMWJfY29sdW1ucyI7YToxNjp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjIzOiJmZWF0dXJlZEltYWdlLmZpbGVfbmFtZSI7czo1OiJsYWJlbCI7czo1OiJJbWFnZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImNhdGVnb3J5Lm5hbWUiO3M6NToibGFiZWwiO3M6ODoiQ2F0ZWdvcnkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWUiO3M6NToibGFiZWwiO3M6NDoiTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6Mzoic2t1IjtzOjU6ImxhYmVsIjtzOjM6IlNLVSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoic2x1ZyI7czo1OiJsYWJlbCI7czo0OiJTbHVnIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJwcmljZSI7czo1OiJsYWJlbCI7czo1OiJQcmljZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InNhbGVfcHJpY2UiO3M6NToibGFiZWwiO3M6MTA6IlNhbGUgcHJpY2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJzdG9ja19xdWFudGl0eSI7czo1OiJsYWJlbCI7czoxNDoiU3RvY2sgcXVhbnRpdHkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6ImluX3N0b2NrIjtzOjU6ImxhYmVsIjtzOjg6IkluIHN0b2NrIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6OTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpc19hY3RpdmUiO3M6NToibGFiZWwiO3M6OToiSXMgYWN0aXZlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImlzX2ZlYXR1cmVkIjtzOjU6ImxhYmVsIjtzOjExOiJJcyBmZWF0dXJlZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjExO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJzb3J0X29yZGVyIjtzOjU6ImxhYmVsIjtzOjEwOiJTb3J0IG9yZGVyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InZpZXdfY291bnQiO3M6NToibGFiZWwiO3M6MTA6IlZpZXcgY291bnQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxMzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6MTQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlVwZGF0ZWQgYXQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjE1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJkZWxldGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJEZWxldGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImY1NjNhMTg2MjVhZmU3MTkzMjQ5ZDhlMGU2YTMzYjc5X2NvbHVtbnMiO2E6ODp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWUiO3M6NToibGFiZWwiO3M6NDoiTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiZW1haWwiO3M6NToibGFiZWwiO3M6MTM6IkVtYWlsIGFkZHJlc3MiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InBob25lIjtzOjU6ImxhYmVsIjtzOjU6IlBob25lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo3OiJzdWJqZWN0IjtzOjU6ImxhYmVsIjtzOjc6IlN1YmplY3QiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6ImlzX3JlYWQiO3M6NToibGFiZWwiO3M6NzoiSXMgcmVhZCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NzoicmVhZF9hdCI7czo1OiJsYWJlbCI7czo3OiJSZWFkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiJlMjhhNjAyNjRhMjhhMGZjNTljN2RjODZiZmZkODI0OF9jb2x1bW5zIjthOjc6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJzaXRlX25hbWUiO3M6NToibGFiZWwiO3M6OToiU2l0ZSBOYW1lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoibG9nb19oZWFkZXJfcGF0aCI7czo1OiJsYWJlbCI7czoxMToiSGVhZGVyIExvZ28iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJmYXZpY29uX3BhdGgiO3M6NToibGFiZWwiO3M6NzoiRmF2aWNvbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiZW1haWwiO3M6NToibGFiZWwiO3M6NToiRW1haWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJwaG9uZV9udW1iZXIiO3M6NToibGFiZWwiO3M6NToiUGhvbmUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJDcmVhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJVcGRhdGVkIGF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6ImNhMWU2YzgxZTNhMzJmNDViNmY5YjhjMDZkMGYzM2UyX2NvbHVtbnMiO2E6Njp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImxvY2FsZSI7czo1OiJsYWJlbCI7czo2OiJMb2NhbGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6InF1ZXN0aW9uIjtzOjU6ImxhYmVsIjtzOjg6IlF1ZXN0aW9uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhbnN3ZXIiO3M6NToibGFiZWwiO3M6NjoiQW5zd2VyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJsb2NhbCI7czo1OiJsYWJlbCI7czo1OiJMb2NhbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiNWMzYWRjN2JlZTI1ZmVjZTk0NWQ4Yjc3OTdiNzI1NzFfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToidGl0bGUiO3M6NToibGFiZWwiO3M6NToiVGl0bGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjg6InRpdGxlX2FyIjtzOjU6ImxhYmVsIjtzOjg6IlRpdGxlIGFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiZGVzY3JpcHRpb24iO3M6NToibGFiZWwiO3M6MTE6IkRlc2NyaXB0aW9uIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoiZGVzY3JpcHRpb25fYXIiO3M6NToibGFiZWwiO3M6MTQ6IkRlc2NyaXB0aW9uIGFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo1OiJpbWFnZSI7czo1OiJsYWJlbCI7czo1OiJJbWFnZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibGluayI7czo1OiJsYWJlbCI7czo0OiJMaW5rIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpc19hY3RpdmUiO3M6NToibGFiZWwiO3M6OToiSXMgYWN0aXZlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiI0OTFmYTNlODIwMTY3ZGNjYjkwNzhiNDQ4ODI1MDhiOV9jb2x1bW5zIjthOjc6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNToiaGVyb19pbWFnZV9wYXRoIjtzOjU6ImxhYmVsIjtzOjEwOiJIZXJvIEltYWdlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToic3RvcnlfdGl0bGUiO3M6NToibGFiZWwiO3M6MTE6IlN0b3J5IFRpdGxlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoic3RvcnlfaW1hZ2VfcGF0aCI7czo1OiJsYWJlbCI7czoxMToiU3RvcnkgSW1hZ2UiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjowO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6InN0b3J5X2ljb25fcGF0aCI7czo1OiJsYWJlbCI7czoxMDoiU3RvcnkgSWNvbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpc19hY3RpdmUiO3M6NToibGFiZWwiO3M6NjoiQWN0aXZlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czo3OiJDcmVhdGVkIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjc6IlVwZGF0ZWQiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319fXM6NjoibG9jYWxlIjtzOjI6ImFyIjt9', 1768313344);

-- ----------------------------
-- Table structure for setting_translations
-- ----------------------------
DROP TABLE IF EXISTS `setting_translations`;
CREATE TABLE `setting_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slogan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `footer_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `default_meta_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `default_meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `default_meta_keywords` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_page_info_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_page_form_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `google_map_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `footer_copyright` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `setting_translations_setting_id_locale_unique`(`setting_id`, `locale`) USING BTREE,
  INDEX `setting_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of setting_translations
-- ----------------------------
INSERT INTO `setting_translations` VALUES (1, 1, 'en', 'RosaCare', 'Rosa from Nature', 'Damascus-based brand in Syria that focuses on creating beauty products inspired by the traditional Damascena rose, a centuries-old symbol of beauty. The brand\'s core ingredients include premium Damascene rose oil and organic Rose Water derived from Rosa Damascena.', 'RosaCare - Premium Damask Rose Products from Syria', 'Discover premium beauty products inspired by the traditional Damascena rose. Premium Damascene rose oil and organic Rose Water derived from Rosa Damascena. Damascus-based brand in Syria.', 'RosaCare, Damask Rose, Damascena Rose, Rose Oil, Rose Water, Natural Beauty Products, Syria, Damascus, Organic Rose Products, Premium Rose Oil', NULL, NULL, NULL, '© 2026 RosaCare. All rights reserved. From the heart of Syria.', NULL, NULL);
INSERT INTO `setting_translations` VALUES (2, 1, 'ar', 'روزاكير', 'الورد من الطبيعة', 'علامة تجارية دمشقية في سوريا تركز على إنشاء منتجات تجميل مستوحاة من الوردة الشامية التقليدية، رمز الجمال الذي عمره قرون. تشمل المكونات الأساسية للعلامة التجارية زيت الورد الشامي المميز وماء الورد العضوي المستخرج من الوردة الشامية.', 'روزاكير - منتجات الوردة الشامية الفاخرة من سوريا', 'اكتشف منتجات التجميل الفاخرة المستوحاة من الوردة الشامية التقليدية. زيت الورد الشامي المميز وماء الورد العضوي المستخرج من الوردة الشامية. علامة تجارية دمشقية في سوريا.', 'روزاكير، الوردة الشامية، زيت الورد، ماء الورد، منتجات تجميل طبيعية، سوريا، دمشق، منتجات الورد العضوية', NULL, NULL, NULL, '© 2026 روزاكير. جميع الحقوق محفوظة. من قلب الشام.', NULL, NULL);

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo_header_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `logo_footer_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `favicon_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `default_meta_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `google_verification_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `google_map_iframe` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `facebook` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `twitter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `instagram` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `linkedin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `youtube` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tiktok` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES (1, 'settings/logos/01KEVMS4VNSKACATR6VC3GW6C0.png', 'settings/logos/01KEVMS4W3YA5A3AWA93ENF8Q7.png', 'settings/favicons/01KEVMS4W4YS0BCWVQVMGXRDQT.png', 'settings/meta/01KEVMS4W6KSSMFGXNKVP6505K.png', NULL, '+963930183648', 'info@rosacare.sy', 'Damascus, Syria', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d831.9073033066226!2d36.31856176994349!3d33.52338062546069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snl!4v1768306115138!5m2!1sen!2snl\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://facebook.com/rosadcare', 'https://facebook.com/rosadcare', 'https://facebook.com/rosadcare', 'https://facebook.com/rosadcare', 'https://facebook.com/rosadcare', 'https://facebook.com/rosadcare', '2026-01-12 13:45:22', '2026-01-13 13:12:46');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin RosaCare', 'admin@rosacare.sy', '2026-01-12 13:45:22', '$2y$12$cCv7obP6hczIalzvPiM39O8equ5ytgITe3eoKUNliyZ20vmnPN8Ze', NULL, NULL, NULL, NULL, '2026-01-12 13:45:22', '2026-01-12 13:45:22');

-- ----------------------------
-- Table structure for welcome_details
-- ----------------------------
DROP TABLE IF EXISTS `welcome_details`;
CREATE TABLE `welcome_details`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_text_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `welcome_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `welcome_details_welcome_id_foreign`(`welcome_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of welcome_details
-- ----------------------------
INSERT INTO `welcome_details` VALUES (5, 'welcomes/details/01KEV6EDC8053BZKCE6RTRYZG8.webp', '/products?category=food', '#9C27B0', '#FFFFFF', 1, 1, '2026-01-13 08:09:35', '2026-01-13 08:09:35');
INSERT INTO `welcome_details` VALUES (4, 'welcomes/details/01KEV6EDC6P3DNMQ6EA7T96VQT.webp', '/products?category=skincare', '#E91E63', '#FFFFFF', 1, 1, '2026-01-13 08:09:35', '2026-01-13 08:09:35');
INSERT INTO `welcome_details` VALUES (6, 'welcomes/details/01KEV6EDCBNYZD2WMS337HS3SA.webp', '/products?category=aromatic', '#673AB7', '#FFFFFF', 1, 1, '2026-01-13 08:09:35', '2026-01-13 08:09:35');

-- ----------------------------
-- Table structure for welcome_details_translations
-- ----------------------------
DROP TABLE IF EXISTS `welcome_details_translations`;
CREATE TABLE `welcome_details_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `welcome_detail_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `button_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `welcome_details_translations_welcome_detail_id_foreign`(`welcome_detail_id`) USING BTREE,
  INDEX `welcome_details_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of welcome_details_translations
-- ----------------------------
INSERT INTO `welcome_details_translations` VALUES (1, 1, 'ar', 'العناية بالبشرة', 'منتجات عناية بالبشرة مصنوعة من الوردة الشامية الطبيعية، مثالية لجميع أنواع البشرة.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (2, 1, 'en', 'Skincare Products', 'Premium skincare products made from natural Damask Rose, perfect for all skin types.', 'Shop Now', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (3, 2, 'ar', 'منتجات غذائية', 'استمتع بنكهة وطعم الوردة الشامية في منتجاتنا الغذائية الطبيعية واللذيذة.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (4, 2, 'en', 'Food Products', 'Enjoy the flavor and taste of Damask Rose in our natural and delicious food products.', 'Shop Now', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (5, 3, 'ar', 'منتجات عطرية', 'استرخي واستمتع بعطور الوردة الشامية الطبيعية التي تنعش حواسك وتريح نفسك.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (6, 3, 'en', 'Aromatic Products', 'Relax and enjoy natural Damask Rose fragrances that refresh your senses and soothe your soul.', 'Shop Now', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (7, 4, 'ar', 'العناية بالبشرة', 'منتجات عناية بالبشرة مصنوعة من الوردة الشامية الطبيعية، مثالية لجميع أنواع البشرة.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (8, 4, 'en', 'Skincare Products', 'Premium skincare products made from natural Damask Rose, perfect for all skin types.', 'Shop Now', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (9, 5, 'ar', 'منتجات غذائية', 'استمتع بنكهة وطعم الوردة الشامية في منتجاتنا الغذائية الطبيعية واللذيذة.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (10, 5, 'en', 'Food Products', 'Enjoy the flavor and taste of Damask Rose in our natural and delicious food products.', 'Shop Now', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (11, 6, 'ar', 'منتجات عطرية', 'استرخي واستمتع بعطور الوردة الشامية الطبيعية التي تنعش حواسك وتريح نفسك.', 'تسوق الآن', NULL, NULL);
INSERT INTO `welcome_details_translations` VALUES (12, 6, 'en', 'Aromatic Products', 'Relax and enjoy natural Damask Rose fragrances that refresh your senses and soothe your soul.', 'Shop Now', NULL, NULL);

-- ----------------------------
-- Table structure for welcome_translations
-- ----------------------------
DROP TABLE IF EXISTS `welcome_translations`;
CREATE TABLE `welcome_translations`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `welcome_id` bigint UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `button_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `welcome_translations_unique`(`welcome_id`, `locale`) USING BTREE,
  INDEX `welcome_translations_locale_index`(`locale`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of welcome_translations
-- ----------------------------
INSERT INTO `welcome_translations` VALUES (1, 1, 'ar', 'نرحب بك في روزا.د.كير', 'اكتشف جمال ومزايا الوردة الشامية مع منتجاتنا المميزة المصنوعة بعناية فائقة من أفضل أنواع الورود الطبيعية.', 'استكشف المنتجات', NULL, NULL);
INSERT INTO `welcome_translations` VALUES (2, 1, 'en', 'Welcome to RosaCare', 'Discover the beauty and benefits of Damask Rose with our premium products, carefully crafted from the finest natural roses.', 'Explore Products', NULL, NULL);

-- ----------------------------
-- Table structure for welcomes
-- ----------------------------
DROP TABLE IF EXISTS `welcomes`;
CREATE TABLE `welcomes`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of welcomes
-- ----------------------------
INSERT INTO `welcomes` VALUES (1, 'welcomes/images/01KEV6EDC2F1W2G3RRD9DKPTG5.webp', 'http://rosacare.test/products', 1, '2026-01-12 13:45:22', '2026-01-13 08:09:35');

SET FOREIGN_KEY_CHECKS = 1;
