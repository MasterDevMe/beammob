ALTER TABLE `songs`
	ADD COLUMN `songPic` VARCHAR(500) NOT NULL AFTER `mixdown`;
	
ALTER TABLE `songs`
	ADD COLUMN `price` FLOAT NOT NULL DEFAULT 0 AFTER `title`;
	
	-- 07/04/2019 Drop song pic column
ALTER TABLE `songs`
	DROP COLUMN `songPic`;