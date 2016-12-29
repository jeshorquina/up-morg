USE upmorg;

CREATE TABLE IF NOT EXISTS `CommitteeMember` (
    `CommitteeMemberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `BatchMemberID` INT UNSIGNED UNIQUE NOT NULL,
    `CommitteeID` INT UNSIGNED NOT NULL,
    `IsApproved` BOOLEAN NOT NULL,
    PRIMARY KEY (`CommitteeMemberID`)
);

ALTER TABLE `CommitteeMember`
ADD CONSTRAINT FK_CommitteeMember_BatchMemberID
FOREIGN KEY(`BatchMemberID`)
REFERENCES BatchMember(`BatchMemberID`);

ALTER TABLE `CommitteeMember`
ADD CONSTRAINT FK_CommitteeMember_CommitteeID
FOREIGN KEY (`CommitteeID`)
REFERENCES Committee(`CommitteeID`);