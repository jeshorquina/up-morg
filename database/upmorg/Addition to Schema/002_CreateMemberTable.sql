USE upmorg;

CREATE TABLE IF NOT EXISTS `Member` (
    `MemberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `FirstName` VARCHAR(50) NOT NULL,
    `MiddleName` VARCHAR(50),
    `LastName` VARCHAR(50) NOT NULL,
    `EmailAddress` VARCHAR(50) NOT NULL,
    `PhoneNumber` VARCHAR(50),
    `Password` VARCHAR(60) NOT NULL,
    PRIMARY KEY(`MemberID`)
);
