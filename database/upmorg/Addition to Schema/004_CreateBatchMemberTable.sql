USE upmorg;

CREATE TABLE IF NOT EXISTS `BatchMember` (
    `BatchMemberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `BatchID` INT UNSIGNED NOT NULL,
    `MemberID` INT UNSIGNED NOT NULL,
    `MemberTypeID` INT UNSIGNED NOT NULL,
    PRIMARY KEY (BatchMemberID)
);

ALTER TABLE `BatchMember`
ADD CONSTRAINT FK_BatchMember_BatchID
FOREIGN KEY (`BatchID`)
REFERENCES Batch(`BatchID`);

ALTER TABLE `BatchMember`
ADD CONSTRAINT FK_BatchMember_MemberID
FOREIGN KEY (`MemberID`)
REFERENCES Member(`MemberID`);

ALTER TABLE `BatchMember`
ADD CONSTRAINT FK_BatchMember_MemberTypeID
FOREIGN KEY (`MemberTypeID`)
REFERENCES MemberType(`MemberTypeID`);
