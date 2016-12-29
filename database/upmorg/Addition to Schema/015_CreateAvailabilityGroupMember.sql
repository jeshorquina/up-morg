USE upmorg;

CREATE TABLE IF NOT EXISTS `AvailabilityGroupMember` (
    `AvailabilityGroupMemberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `AvailabilityMemberID` INT UNSIGNED NOT NULL,
    `AvailabilityGroupID` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`AvailabilityGroupMemberID`)
);

ALTER TABLE `AvailabilityGroupMember`
ADD CONSTRAINT FK_AvailabilityGroupMember_AvailabilityMemberID
FOREIGN KEY (`AvailabilityMemberID`)
REFERENCES AvailabilityMember(`AvailabilityMemberID`);

ALTER TABLE `AvailabilityGroupMember`
ADD CONSTRAINT FK_AvailabilityGroupMember_AvailabilityGroupID
FOREIGN KEY (`AvailabilityGroupID`)
REFERENCES AvailabilityGroup(`AvailabilityGroupID`);
