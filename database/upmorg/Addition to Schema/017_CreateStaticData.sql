USE upmorg;

CREATE TABLE IF NOT EXISTS `StaticData` (
    `StaticDataID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `Name` VARCHAR(50) NOT NULL,
    `Value` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`StaticDataID`)
);
