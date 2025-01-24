-- Create the Ukulele database
CREATE DATABASE IF NOT EXISTS Ukulele;

-- Use the Ukulele database
USE Ukulele;

-- Create the Registration table
CREATE TABLE Registration (
    RegID INT AUTO_INCREMENT PRIMARY KEY,
    Name1 VARCHAR(15),
    Name2 VARCHAR(15),
    PhoneNo VARCHAR(15),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Gender ENUM('Male', 'Female'),
    RegType ENUM('Customer', 'DJ', 'Mcee', 'Storeman', 'Accountant', 'Dispatchman', 'Inspector', 'Band', 'Admin', 'Supplier'),
    dLocation ENUM('Nairobi CBD', 'Westlands', 'Karen', 'Langata', 'Kilimani', 'Eastleigh', 'Umoja', 'Parklands', 'Ruiru', 'Ruai', 'Gikambura', 'Kitengela', 'Nairobi West', 'Nairobi East'),
    PhotoPath VARCHAR(255),  -- Column for storing the file path to the photo
    accStatus ENUM('Pending', 'Approved', 'Inactive'),
    lastAccessed TIMESTAMP,
    latitude DECIMAL(9, 6),       -- New column for latitude
    longitude DECIMAL(9, 6)       -- New column for longitude
);

-- Create the Customer table
CREATE TABLE Customer (
    RegID INT,
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    Name1 VARCHAR(255),
    Email VARCHAR(255),
    PhoneNo VARCHAR(15),
    Location VARCHAR(255),
    AccountBalance INT,
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Create the Member table
CREATE TABLE Member (
    RegID INT,
    MemberID INT AUTO_INCREMENT PRIMARY KEY,
    Type ENUM('Admin', 'DJ', 'Mcee', 'Band', 'Storeman', 'Accountant', 'Dispatchman', 'Inspector', 'Supplier'),
    Name VARCHAR(255),
    PhoneNo VARCHAR(15),
    PaymentStatus ENUM('Paid', 'Not Paid'),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Create the Inventory table
CREATE TABLE Inventory (
    EquipmentID INT AUTO_INCREMENT PRIMARY KEY,
    Price INT,
    Description ENUM('Speaker', 'Microphone', 'Mixer', 'CDJ', 'Cable', 'Wireless'),
    PurchaseDate DATE,
    Condition ENUM('CAT1', 'CAT2', 'CAT3', 'CAT4'), 
    Availability ENUM('Available', 'Unavailable')
);

-- Create the Inspector table
CREATE TABLE Inspector (
    EquipmentID INT,
    InspectionID INT AUTO_INCREMENT PRIMARY KEY,
    InspectionDate DATE,
    InspectorName VARCHAR(255),
    Condition ENUM('CAT1', 'CAT2', 'CAT3', 'CAT4'),
    FOREIGN KEY (EquipmentID) REFERENCES Inventory(EquipmentID)
);

-- Create the Penalty table
CREATE TABLE Penalty (
    PenaltyID INT AUTO_INCREMENT PRIMARY KEY,
    EquipmentID INT,
    Description ENUM('Speaker', 'Microphone', 'Mixer', 'CDJ', 'Cable', 'Wireless'),
    Condition ENUM('CAT1', 'CAT2', 'CAT3', 'CAT4'),
    Penalty INT,
    FOREIGN KEY (EquipmentID) REFERENCES Inventory(EquipmentID)
);

-- Create the Supply table
CREATE TABLE Supply (
    EquipmentID INT,
    Price INT,
    SupplierName VARCHAR(255),
    SupplyDate DATE,
    PhoneNo VARCHAR(15),
    SupplyStatus ENUM('Delivered', 'Undelivered'),
    FOREIGN KEY (EquipmentID) REFERENCES Inventory(EquipmentID)
);

-- Create the Finance table with added PhoneNo field
CREATE TABLE Finance (
    CustomerID INT,
    Name1 VARCHAR(255),
    PhoneNo VARCHAR(15), -- Added PhoneNo field
    TransactionID INT AUTO_INCREMENT PRIMARY KEY,
    TransactionDate DATE,
    Amount INT,
    TransactType ENUM('Deposit', 'Payment'),  -- Added TransactType field
    Balance INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

-- Create the Payment table with added PhoneNo field
CREATE TABLE Payment (
    MemberID INT,
    Name VARCHAR(255),
    PhoneNo VARCHAR(15), -- Added PhoneNo field
    ProcessID INT AUTO_INCREMENT PRIMARY KEY,
    Amount INT,
    Date DATE,
    FOREIGN KEY (MemberID) REFERENCES Member(MemberID)
);

-- Create the Services table with added PhoneNo field
CREATE TABLE Services (
    ServiceID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT,
    PhoneNo VARCHAR(15),
    Genre ENUM('Reggae', 'Rhumba', 'Zilizopendwa', 'Benga', 'Soul', 'RnB'),
    Cost INT,
    Hours INT,
    ServiceType ENUM('Lending', 'Booking'),  -- Added to differentiate types of services
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

-- Create the Lending table
CREATE TABLE Lending (
    LendID INT AUTO_INCREMENT PRIMARY KEY,
    EquipmentID INT,
    LendingDate DATE,
    Cost INT,
    Hours INT,
    ServiceID INT,
    LendingStatus ENUM('Done', 'Yet'),
    FOREIGN KEY (EquipmentID) REFERENCES Inventory(EquipmentID),
    FOREIGN KEY (ServiceID) REFERENCES Services(ServiceID)  -- Linking to Services
);

-- Create the Booking table
CREATE TABLE Booking (
    BookingID INT AUTO_INCREMENT PRIMARY KEY,
    Genre ENUM('Reggae', 'Rhumba', 'Zilizopendwa', 'Benga', 'Soul', 'RnB'),
    BookingDate DATE,
    Cost INT,
    Hours INT,
    ServiceID INT,
    BookStatus ENUM('Tick', 'Untick'),
    FOREIGN KEY (ServiceID) REFERENCES Services(ServiceID)  -- Linking to Services
);

-- Create the Dispatch table with added PhoneNo field
CREATE TABLE Dispatch (
    DispatchID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT,
    Name VARCHAR(255),
    Location VARCHAR(255),
    EquipmentID INT,
    PhoneNo VARCHAR(15), -- Added PhoneNo field
    Dispatched ENUM('Yes', 'No'), -- New Dispatched field
    DispatchDate DATE,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (EquipmentID) REFERENCES Inventory(EquipmentID)
);

-- Create the Feedback table
CREATE TABLE Feedback (
    FeedbackID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT,
    Name VARCHAR(255),
    Comments TEXT,
    Response TEXT,
    Rating INT,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    CHECK (Rating >= 1 AND Rating <= 5)
);

-- Create the Stats table
CREATE TABLE Stats (
    StatID INT AUTO_INCREMENT PRIMARY KEY,
    Lending INT,
    LivePerformance INT,
    Total INT,
    Date DATE
);

-- Create the About table
CREATE TABLE About (
    Detail TEXT
);

-- Create the Contact table
CREATE TABLE Contact (
    PhoneNo VARCHAR(15),
    EmailAddress VARCHAR(255),
    Instagram VARCHAR(255),
    Facebook VARCHAR(255),
    POBox VARCHAR(255)
);
