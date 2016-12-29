USE upmorg;

CREATE TABLE IF NOT EXISTS `Committee` (
    `CommitteeID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `CommitteeHeadID` INT UNSIGNED NOT NULL,
    `CommitteeName` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`CommitteeID`)
);

ALTER TABLE `Committee`
ADD CONSTRAINT FK_Committee_CommitteeHeadID
FOREIGN KEY (`CommitteeHeadID`)
REFERENCES BatchMember(`BatchMemberID`);