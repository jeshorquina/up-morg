USE upmorg;

CREATE TABLE IF NOT EXISTS `CommitteePermission` (
`CommitteePermissionID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`CommitteeID` INT UNSIGNED NOT NULL,
`MemberTypeID` INT UNSIGNED NOT NULL,
PRIMARY KEY (CommitteePermissionID)
);

ALTER TABLE `CommitteePermission`
ADD CONSTRAINT FK_CommitteePermission_CommitteeID
FOREIGN KEY (`CommitteeID`)
REFERENCES Committee(`CommitteeID`);

ALTER TABLE `CommitteePermission`
ADD CONSTRAINT FK_CommitteePermission_MemberTypeID
FOREIGN KEY (`MemberTypeID`)
REFERENCES MemberType(`MemberTypeID`);
