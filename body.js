// Import database connection (connect.php provides an endpoint for querying)
import db from './connect.php'; // Placeholder import for PHP integration

// Parent Class: Record
class Record {
    constructor(RegID, Name, PhoneNo) {
        this.RegID = RegID;
        this.Name = Name;
        this.PhoneNo = PhoneNo;
    }

    // Method to fetch a record by ID (abstracted for subclasses)
    async fetchById(id) {
        const response = await fetch(`connect.php?id=${id}`);
        const data = await response.json();
        this.populateFields(data);
    }

    // Populate fields from data object (to be overridden by subclasses)
    populateFields(data) {
        this.RegID = data.RegID || this.RegID;
        this.Name = data.Name || this.Name;
        this.PhoneNo = data.PhoneNo || this.PhoneNo;
    }
}

// Base Class for Registration
class Registration extends Record {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, RegType, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude) {
        super(RegID, Name, PhoneNo);
        this.Email = Email;
        this.Password = Password;
        this.Gender = Gender;
        this.RegType = RegType;
        this.dLocation = dLocation;
        this.PhotoPath = PhotoPath;
        this.accStatus = accStatus;
        this.lastAccessed = lastAccessed;
        this.latitude = latitude;
        this.longitude = longitude;
    }

    populateFields(data) {
        super.populateFields(data);
        this.Email = data.Email;
        this.Password = data.Password;
        this.Gender = data.Gender;
        this.RegType = data.RegType;
        this.dLocation = data.dLocation;
        this.PhotoPath = data.PhotoPath;
        this.accStatus = data.accStatus;
        this.lastAccessed = data.lastAccessed;
        this.latitude = data.latitude;
        this.longitude = data.longitude;
    }
}

// Subclasses for each RegType (inherit from Registration)

// DJ Class
class DJ extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, DJSkillLevel) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'DJ', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.DJSkillLevel = DJSkillLevel;
    }

    populateFields(data) {
        super.populateFields(data);
        this.DJSkillLevel = data.DJSkillLevel;
    }
}

// Mcee Class
class Mcee extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, Specialization) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Mcee', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.Specialization = Specialization;
    }

    populateFields(data) {
        super.populateFields(data);
        this.Specialization = data.Specialization;
    }
}

// Storeman Class
class Storeman extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, StorageSection) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Storeman', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.StorageSection = StorageSection;
    }

    populateFields(data) {
        super.populateFields(data);
        this.StorageSection = data.StorageSection;
    }
}

// Accountant Class
class Accountant extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, CPAQualification) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Accountant', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.CPAQualification = CPAQualification;
    }

    populateFields(data) {
        super.populateFields(data);
        this.CPAQualification = data.CPAQualification;
    }
}

// Dispatchman Class
class Dispatchman extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, DeliveryArea) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Dispatchman', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.DeliveryArea = DeliveryArea;
    }

    populateFields(data) {
        super.populateFields(data);
        this.DeliveryArea = data.DeliveryArea;
    }
}

// Inspector Class
class Inspector extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, InspectionExperience) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Inspector', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.InspectionExperience = InspectionExperience;
    }

    populateFields(data) {
        super.populateFields(data);
        this.InspectionExperience = data.InspectionExperience;
    }
}

// Band Class
class Band extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, BandMembers) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Band', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.BandMembers = BandMembers;
    }

    populateFields(data) {
        super.populateFields(data);
        this.BandMembers = data.BandMembers;
    }
}

// Admin Class
class Admin extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, PermissionsLevel) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Admin', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.PermissionsLevel = PermissionsLevel;
    }

    populateFields(data) {
        super.populateFields(data);
        this.PermissionsLevel = data.PermissionsLevel;
    }
}

// Supplier Class
class Supplier extends Registration {
    constructor(RegID, Name, PhoneNo, Email, Password, Gender, dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude, SupplyAreas) {
        super(RegID, Name, PhoneNo, Email, Password, Gender, 'Supplier', dLocation, PhotoPath, accStatus, lastAccessed, latitude, longitude);
        this.SupplyAreas = SupplyAreas;
    }

    populateFields(data) {
        super.populateFields(data);
        this.SupplyAreas = data.SupplyAreas;
    }
}

// Export all classes
export { Record, Registration, DJ, Mcee, Storeman, Accountant, Dispatchman, Inspector, Band, Admin, Supplier };
