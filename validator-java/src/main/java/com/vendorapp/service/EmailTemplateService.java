// service/EmailTemplateService.java
package com.vendorapp.service;

import com.vendorapp.model.Vendor;

public class EmailTemplateService {

    public static String getApprovalMessage(Vendor v) {
        return "Dear " + v.getContactPerson() + ",\n\n" +
               "We are pleased to inform you that your vendor application has been approved. " +
               "Your experience and compliance with our quality standards make you a suitable partner for Terravin Wine Company.\n\n" +
               "Welcome aboard!\n\nSincerely,\nTerravin Vendor Management Team";
    }

    public static String getRejectionMessage(Vendor v) {
        StringBuilder message = new StringBuilder();
        message.append("Dear ").append(v.getContactPerson()).append(",\n\n");
        message.append("Thank you for your interest in becoming a vendor for Terravin Wine Company.\n");

        message.append("After reviewing your application, we have determined that it currently does not meet the necessary criteria. ")
               .append("Here are some areas that could be improved:\n\n");

        if (v.getYearsInOperation() < 2) message.append("- Increase operational experience (at least 2 years required).\n");
        if (v.getAnnualTurnover() < 50000) message.append("- Improve financial standing (minimum annual turnover: $50,000).\n");
        if (!v.isHasOrganicCertification()) message.append("- Organic certification is highly recommended.\n");
        if (!v.isHasISO22000Certification()) message.append("- ISO 22000 food safety certification improves eligibility.\n");
        if (!v.isCompliantWithLocalRegulations()) message.append("- Ensure full compliance with all local business regulations.\n");

        message.append("\nWe encourage you to reapply in the future once the above areas are addressed.\n\n")
               .append("Warm regards,\nTerravin Vendor Management Team");

        return message.toString();
    }
}
