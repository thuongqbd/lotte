-- select kimono
SELECT DISTINCT
  `t`.`product_id` AS `t0_c0`,
  `t`.`brand_name` AS `t0_c8`,
  `t`.`main_thumb_image` AS `t0_c10`,
  `t`.`main_image` AS `t0_c11`,
  `t`.`for_sex` AS `t0_c7`,
  `t`.`history` AS `t0_c4` 
FROM `product` `t` 
  LEFT OUTER JOIN `product_lang` `i18nProduct` ON (`i18nProduct`.`product_id` = `t`.`product_id`) AND (i18nProduct.lang_id = 'ja') 
  LEFT OUTER JOIN `customer` `customer` ON (`customer`.`product_id` = `t`.`product_id`) 
  LEFT OUTER JOIN `product_type` `productType` ON (`t`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_type_lang` `i18nProductType` ON (`i18nProductType`.`product_type_id` = `productType`.`product_type_id`) AND (i18nProductType.lang_id = 'ja') 
  LEFT OUTER JOIN `season` `season` ON (`season`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_class` `productClass` ON (`productClass`.`product_id` = `t`.`product_id`) 
  LEFT OUTER JOIN `pclass_cate` `pclassCate` ON (`productClass`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) 
  LEFT OUTER JOIN `pclass_cate_lang` `i18nPclassCate` ON (`i18nPclassCate`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) AND (i18nPclassCate.lang_id = 'ja') 
WHERE t.service = 1 AND t.grade = 1 AND t.status = 1 AND t.for_sex = 1 AND t.delete_flag = 1 AND t.hire_on = 1 
	AND (DATE_FORMAT('2015-03-17', "%m-%d") BETWEEN DATE_FORMAT(season.begin_date, "%m-%d") AND DATE_FORMAT(season.end_date, "%m-%d")) 
    AND (t.shop_id = 1 OR t.shop_id IN (SELECT shop_id FROM distribution WHERE dedicate_to_id = 1)) 
    AND NOT EXISTS (
		SELECT 1 FROM book b, plan p, customer c, customer_option co
		WHERE c.product_id = t.product_id AND b.payment_status <> 2 AND b.status = 1 
			AND (DATEDIFF('2015-03-17', c.booking_hour) BETWEEN -1 AND IF(co.option_id = 4,1,0))
	)
--------------------------------------------------------------------------
-- select kimono for HT thue kimono hakama (Raiten)
-- 3.1. 当日ご来店・着付けあり(Người thuê chọn 1 ngày đến shop)																					
-- condition:
book.book_type = 2 - hakama
rent_hakama_type  = 1 - den shop
distant_flag = 0
shop_id = 1 - Shinkyoka
booking_date = T between T-1 AND T+2
T = 2015-3-17
T1 = 2015-3-16
T2 = 2015-3-19
product_grate = 8 // プレミアム2尺袖 - Premium - Two shaku sleeves
plan_type = 9
--------------------------------------------------------------------------
-- select kimono
SELECT 
  `t`.`product_id`,
  `t`.`brand_name`,
  `t`.`main_thumb_image`,
  `t`.`main_image`,
  `t`.`for_sex`,
  `t`.`history` 
FROM
  `product` `t` 
  LEFT OUTER JOIN `product_lang` `i18nProduct` ON (`i18nProduct`.`product_id` = `t`.`product_id`) AND (i18nProduct.lang_id = 'ja') 
  LEFT OUTER JOIN `product_type` `productType` ON (`t`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_type_lang` `i18nProductType` ON (`i18nProductType`.`product_type_id` = `productType`.`product_type_id`) AND (i18nProductType.lang_id = 'ja') 
  LEFT OUTER JOIN `season` `season` ON (`season`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_class` `productClass` ON (`productClass`.`product_id` = `t`.`product_id`) 
  LEFT OUTER JOIN `pclass_cate` `pclassCate` ON (`productClass`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) 
  LEFT OUTER JOIN `pclass_cate_lang` `i18nPclassCate` ON (`i18nPclassCate`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) AND (i18nPclassCate.lang_id = 'ja') 
WHERE 
    t.service = 1 
    AND t.grade IN (8) 
    AND t.status = 1 
    AND t.for_sex = 1 
    AND t.delete_flag = 0 
    AND t.hire_on = 1 
    AND (
      DATE_FORMAT('2015-03-23', "%m-%d") BETWEEN DATE_FORMAT(season.begin_date, "%m-%d") 
      AND DATE_FORMAT(season.end_date, "%m-%d")
    ) 
    AND (t.shop_id = 1 OR t.shop_id IN (SELECT shop_id FROM distribution WHERE dedicate_to_id = 1)) 
    AND NOT EXISTS (SELECT 1 FROM book b, plan p, customer c 
					WHERE c.product_id = t.product_id 
							AND b.payment_status <> 2 
							AND b.status = 1 
							AND b.book_id = p.book_id 
							AND p.plan_id = c.plan_id 
							AND IF(DATEDIFF('03-22-2015', c.`waiting_begin`) >= 0,1,0) 
							AND IF(DATEDIFF('03-25-2015', c.`waiting_end`) <= 0,1,0))
  
GROUP BY t.product_id 
--------------------------------------------------------------------------
-- select hakama
SELECT 
  `t`.`product_id`,
  `t`.`brand_name`,
  `t`.`main_thumb_image`,
  `t`.`main_image`,
  `t`.`for_sex`,
  `t`.`history` 
FROM
  `product` `t` 
  LEFT OUTER JOIN `product_lang` `i18nProduct` ON (`i18nProduct`.`product_id` = `t`.`product_id`) AND (i18nProduct.lang_id = 'ja') 
  LEFT OUTER JOIN `product_type` `productType` ON (`t`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_type_lang` `i18nProductType` ON (`i18nProductType`.`product_type_id` = `productType`.`product_type_id`) AND (i18nProductType.lang_id = 'ja') 
  LEFT OUTER JOIN `season` `season` ON (`season`.`product_type_id` = `productType`.`product_type_id`) 
  LEFT OUTER JOIN `product_class` `productClass` ON (`productClass`.`product_id` = `t`.`product_id`) 
  LEFT OUTER JOIN `pclass_cate` `pclassCate` ON (`productClass`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) 
  LEFT OUTER JOIN `pclass_cate_lang` `i18nPclassCate` ON (`i18nPclassCate`.`pclass_cate_id` = `pclassCate`.`pclass_cate_id`) AND (i18nPclassCate.lang_id = 'ja') 
WHERE 
    t.service = 1 
    AND t.grade IN (9,10) 
    AND t.status = 1 
    AND t.for_sex = 1 
    AND t.delete_flag = 0 
    AND t.hire_on = 1 
    AND (
      DATE_FORMAT('2015-03-23', "%m-%d") BETWEEN DATE_FORMAT(season.begin_date, "%m-%d") 
      AND DATE_FORMAT(season.end_date, "%m-%d")
    ) 
    AND (t.shop_id = 1 OR t.shop_id IN (SELECT shop_id FROM distribution WHERE dedicate_to_id = 1)) 
    AND NOT EXISTS (SELECT 1 FROM book b, plan p, customer c 
					WHERE c.product_id = t.product_id 
							AND b.payment_status <> 2 
							AND b.status = 1 
							AND b.book_id = p.book_id 
							AND p.plan_id = c.plan_id 
							AND IF(DATEDIFF('03-22-2015', c.`waiting_begin`) >= 0,1,0) 
							AND IF(DATEDIFF('03-25-2015', c.`waiting_end`) <= 0,1,0))
  
GROUP BY t.product_id 
---------------------------------------------------------------------------------------------------------------------------
--- isAvailableKimonoHakama
SELECT 
  `t`.`product_id` AS `t0_c0`,
  `i18nProduct`.`lang_id` AS `t1_c2`,
  `i18nProduct`.`l_product_name` AS `t1_c3`,
  `i18nProduct`.`l_brand_name` AS `t1_c5`,
  `i18nProduct`.`l_product_caption` AS `t1_c4`,
  `i18nProduct`.`product_lang_id` AS `t1_c0`,
  `productType`.`product_type_id` AS `t2_c0`,
  `productType`.`product_type_name` AS `t2_c1`,
  `productType`.`female_allow` AS `t2_c2`,
  `productType`.`male_allow` AS `t2_c3`,
  `productType`.`girl_allow` AS `t2_c4`,
  `productType`.`boy_allow` AS `t2_c5`,
  `productType`.`seasonal_flag` AS `t2_c6`,
  `productType`.`order_num` AS `t2_c7`,
  `productType`.`description` AS `t2_c8`,
  `productType`.`delete_flag` AS `t2_c9`,
  `i18nProductType`.`lang_id` AS `t3_c2`,
  `i18nProductType`.`l_product_type_name` AS `t3_c3`,
  `i18nProductType`.`product_type_lang_id` AS `t3_c0`,
  `season`.`season_id` AS `t4_c0`,
  `season`.`season_name` AS `t4_c1`,
  `season`.`product_type_id` AS `t4_c2`,
  `season`.`begin_date` AS `t4_c3`,
  `season`.`end_date` AS `t4_c4` 
FROM
  `product` `t` 
  LEFT OUTER JOIN `product_lang` `i18nProduct` 
    ON (
      `i18nProduct`.`product_id` = `t`.`product_id`
    ) 
    AND (i18nProduct.lang_id = 'ja') 
  LEFT OUTER JOIN `product_type` `productType` 
    ON (
      `t`.`product_type_id` = `productType`.`product_type_id`
    ) 
  LEFT OUTER JOIN `product_type_lang` `i18nProductType` 
    ON (
      `i18nProductType`.`product_type_id` = `productType`.`product_type_id`
    ) 
    AND (i18nProductType.lang_id = 'ja') 
  LEFT OUTER JOIN `season` `season` 
    ON (
      `season`.`product_type_id` = `productType`.`product_type_id`
    ) 
WHERE (t.service = 1 
  AND t.status = 1 
  AND t.delete_flag = 0 
  AND t.hire_on = 1 
  AND (
    DATE_FORMAT('2015-03-24', '%m-%d') BETWEEN DATE_FORMAT(season.begin_date, '%m-%d') 
    AND DATE_FORMAT(season.end_date, '%m-%d')
  ) 
  AND NOT EXISTS 
  (SELECT 
    1 
  FROM
    book b,
    plan p,
    customer c 
    WHERE c.product_id = t.product_id 
AND b.payment_status <> 2 
AND b.status = 1 
AND b.book_id = p.book_id 
AND p.plan_id = c.plan_id 
AND IF(DATEDIFF(DATE_ADD('2015-03-24', INTERVAL +4 DAY), c.`waiting_begin`) >= 0,1,0) 
AND IF(DATEDIFF(DATE_ADD('2015-03-24', INTERVAL -5 DAY), c.`waiting_end`) <= 0,1,0)))
 AND t.product_id =162







