USE upmorg;

CREATE TABLE IF NOT EXISTS `AvailabilityMember` (
    `AvailabilityMemberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `BatchMemberID` INT UNSIGNED NOT NULL,
    `MondayVector` CHAR(96) NOT NULL,
    `TuesdayVector` CHAR(96) NOT NULL,
    `WednesdayVector` CHAR(96) NOT NULL,
    `ThursdayVector` CHAR(96) NOT NULL,
    `FridayVector` CHAR(96) NOT NULL,
    `SaturdayVector` CHAR(96) NOT NULL,
    `SundayVector` CHAR(96) NOT NULL,
    PRIMARY KEY (`AvailabilityMemberID`)
);

ALTER TABLE `AvailabilityMember`
ADD CONSTRAINT FK_AvailabilityMember_BatchMemberID
FOREIGN KEY (`BatchMemberID`)
REFERENCES BatchMember(`BatchMemberID`);
