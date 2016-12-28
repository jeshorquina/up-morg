USE upmorg;

CREATE TABLE IF NOT EXISTS `Task` (
    `TaskID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ParentTaskID` INT UNSIGNED,
    `TaskStatusID` INT UNSIGNED NOT NULL,
    `EventID` INT UNSIGNED, 
    `Reporter` INT UNSIGNED NOT NULL,
    `Assignee` INT UNSIGNED NOT NULL,
    `TaskTitle` VARCHAR(255) NOT NULL,
    `TaskDescription` VARCHAR(511) NOT NULL,
    `TaskDeadline` DATE NOT NULL,
    `Timestamp` DATETIME NOT NULL,
    PRIMARY KEY (`TaskID`)
);

ALTER TABLE `Task`
ADD CONSTRAINT FK_Task_ParentTaskID
FOREIGN KEY (`ParentTaskID`)
REFERENCES Task(`TaskID`);

ALTER TABLE `Task`
ADD CONSTRAINT FK_Task_TaskStatusID
FOREIGN KEY (`TaskStatusID`)
REFERENCES TaskStatus(`TaskStatusID`);

ALTER TABLE `Task`
ADD CONSTRAINT FK_Task_EventID
FOREIGN KEY (`EventID`)
REFERENCES Event(`EventID`);

ALTER TABLE `Task`
ADD CONSTRAINT FK_Task_Reporter
FOREIGN KEY (`Reporter`)
REFERENCES BatchMember(`BatchMemberID`);

ALTER TABLE `Task`
ADD CONSTRAINT FK_Task_Assignee
FOREIGN KEY (`Assignee`)
REFERENCES BatchMember(`BatchMemberID`);
