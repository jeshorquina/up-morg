USE upmorg;

CREATE TABLE IF NOT EXISTS `AvailabilityGroup` (
    `AvailabilityGroupID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `FrontmanID` INT UNSIGNED NOT NULL,
    `GroupName` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`AvailabilityGroupID`)
);

ALTER TABLE `AvailabilityGroup`
ADD CONSTRAINT FK_AvailabilityGroup_FrontmanID
FOREIGN KEY (`FrontmanID`)
REFERENCES BatchMember(`BatchMemberID`);
