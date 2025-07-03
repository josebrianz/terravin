// service/VendorValidationService.java
package com.vendorapp.service;

import com.vendorapp.model.Vendor;

public class VendorValidationService {

    public static boolean basicValidation(Vendor v) {
        return v.getCompanyName() != null &&
               v.getEmail() != null && v.getEmail().contains("@") &&
               v.getYearsInOperation() >= 2 &&
               v.getAnnualTurnover() >= 50000 &&
               v.getMaterialSupplied() != null &&
               v.isCompliantWithLocalRegulations();
    }

    public static double scoreVendor(Vendor v) {
        double score = 0;

        // Weighted scoring (out of 100)
        score += (v.getYearsInOperation() >= 5) ? 20 : (v.getYearsInOperation() * 4); // max 20
        score += (v.getAnnualTurnover() >= 100000) ? 20 : (v.getAnnualTurnover() / 5000); // max 20
        score += (v.getNumberOfEmployees() >= 50) ? 10 : (v.getNumberOfEmployees() * 0.2); // max 10
        score += (v.isHasOrganicCertification()) ? 15 : 0;
        score += (v.isHasISO22000Certification()) ? 15 : 0;
        score += (v.getPreviousClients() != null && !v.getPreviousClients().isEmpty()) ? 10 : 0;
        score += (v.isCompliantWithLocalRegulations()) ? 10 : 0;

        return Math.min(score, 100);
    }

    public static boolean isApproved(Vendor v) {
        return basicValidation(v) && scoreVendor(v) >= 70;
    }
}
