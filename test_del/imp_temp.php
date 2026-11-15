SELECT r1.`recipe_id`,`recipe_name`,`recipe_description`,`recipe_step`,`recipe_ingredient`,`added_by` FROM `recipe` as r1 JOIN `recpe_level_3_catagorization_map` AS r2 ON r1.`recipe_id`= r2.`recipe_id` JOIN `Level_3_catagorization` as r3 on r2.`category3_id` = r3.`catagory3_id` WHERE r3.catagory3_id = 93;



SELECT * FROM (SELECT r1.`recipe_id`,`recipe_name`,`recipe_description`,`recipe_step`,`recipe_ingredient`,`added_by` FROM `recipe` as r1 JOIN `recpe_level_3_catagorization_map` AS r2 ON r1.`recipe_id`= r2.`recipe_id` JOIN `Level_3_catagorization` as r3 on r2.`category3_id` = r3.`catagory3_id` WHERE r3.catagory3_id = 102) AS t1 JOIN (SELECT r1.`recipe_id`,`recipe_name`,`recipe_description`,`recipe_step`,`recipe_ingredient`,`added_by` FROM `recipe` as r1 JOIN `recpe_level_3_catagorization_map` AS r2 ON r1.`recipe_id`= r2.`recipe_id` JOIN `Level_3_catagorization` as r3 on r2.`category3_id` = r3.`catagory3_id` WHERE r3.catagory3_id = 93) AS t2 on t1.`recipe_id` = t2.`recipe_id`;
