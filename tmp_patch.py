import os

file_path = "d:/Project Conver/laravelPr/public/js/studentapplicationPdf.js"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Margins
content = content.replace("const M = 1;", "const M = 6;")

# 2. Add cursor x
content = content.replace("let y = M;\n", "let y = M;\n    let cx = M + 4;\n")

# 3. Replace drawField with layoutField
draw_field_src = """    // Draw a label (normal) then a boxed value inline, returns x after box
    function drawField(x, yy, label, value, boxW) {
        doc.setFont('Bornomala', 'normal');
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0); // Pure black labels
        const lw = doc.getTextWidth(label) + 1;
        doc.text(label, x, yy + 4);

        // value box
        const bx = x + lw;
        const finalValue = String(value || '');
        // Only draw minimum width if it's not explicitly provided to have some space
        const bw = boxW || Math.max(doc.getTextWidth(finalValue) + 4, 15);
        const bh = 5;

        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.setLineWidth(0.2);
        // Box is transparent, so it just draws outline
        doc.rect(bx, yy + 0.5, bw, bh);

        if (finalValue) {
            doc.setFont('Bornomala', 'bold');
            doc.setFontSize(8);
            doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
            doc.text(finalValue, bx + 1.5, yy + 4.2);
        }

        return bx + bw + 2;   // next x
    }"""

layout_field_src = """    function layoutField(label, value, baseW = 0) {
        doc.setFont('Bornomala', 'normal');
        doc.setFontSize(11); 
        doc.setTextColor(0, 0, 0); 
        const finalValue = value ? String(value) : '';
        const lw = doc.getTextWidth(label) + 1;
        
        doc.setFont('Bornomala', 'bold');
        const vw = Math.max(doc.getTextWidth(finalValue) + 4, baseW || 15);
        const totalW = lw + vw + 1;
        
        if (cx + totalW > pw - M) {
            cx = M + 4;
            y += 8; // Drop to next line
        }
        
        doc.setFont('Bornomala', 'normal');
        doc.text(label, cx, y + 4.2);
        
        const bx = cx + lw;
        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.setLineWidth(0.2);
        doc.rect(bx, y + 0.5, vw, 5); // Box 5mm high
        
        if (finalValue) {
            doc.setFont('Bornomala', 'bold');
            doc.setFontSize(11);
            doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
            doc.text(finalValue, bx + 1.5, y + 4.2);
        }
        
        cx = bx + vw + 3; 
    }"""
content = content.replace(draw_field_src, layout_field_src)

# 4. Enlarge headers
header_src = """        // Center text
        doc.setTextColor(0, 0, 0); // Black text on colored header
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(16);
        doc.text('HAZERA-TAJU DEGREE COLLEGE', pw / 2, y + 8, { align: 'center' });
        doc.setFont('Bornomala', 'normal');
        doc.setFontSize(8);
        doc.text('B.Sc Chattar, Chandgaon, Chattogram', pw / 2, y + 13, { align: 'center' });
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(9);
        const progName = getNameById(lookups.programs, fd.program);
        doc.text(`Application Form For ${progName || 'Admission'} Admission`, pw / 2, y + 18, { align: 'center' });

        doc.setFontSize(14);
        doc.setTextColor(0, 0, 0); 
        doc.text(`${getNameById(lookups.groups, fd.group) || ''} Group`, pw / 2, y + 24, { align: 'center' });
        doc.setFontSize(8);
        doc.setTextColor(0, 0, 0);
        doc.text(`Session : ${getNameById(lookups.admissionSessions, fd.session) || '20XX-20XX'}`, pw / 2, y + 28, { align: 'center' });"""

header_dst = """        // Center text
        doc.setTextColor(0, 0, 0); // Black text on colored header
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(22);
        doc.text('HAZERA-TAJU DEGREE COLLEGE', pw / 2, y + 8, { align: 'center' });
        doc.setFont('Bornomala', 'normal');
        doc.setFontSize(11);
        doc.text('B.Sc Chattar, Chandgaon, Chattogram', pw / 2, y + 13, { align: 'center' });
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(14);
        const progName = getNameById(lookups.programs, fd.program);
        doc.text(`Application Form For ${progName || 'Admission'} Admission`, pw / 2, y + 18, { align: 'center' });

        doc.setFontSize(18);
        doc.setTextColor(0, 0, 0); 
        doc.text(`${getNameById(lookups.groups, fd.group) || ''} Group`, pw / 2, y + 25, { align: 'center' });
        doc.setFontSize(11);
        doc.setTextColor(0, 0, 0);
        doc.text(`Session : ${getNameById(lookups.admissionSessions, fd.session) || '20XX-20XX'}`, pw / 2, y + 30, { align: 'center' });"""
content = content.replace(header_src, header_dst)

# Reduce header height from 30 to 32 to fix the session overlap
content = content.replace("const hh = 30;", "const hh = 32;")

# 5. Fix Section 1 to 7 layout replacements
section_src = """        // ============================================
        // 1. Students Information
        // ============================================
        let sy = startSection('1. Students Information');
        let rx;

        rx = drawField(M + 4, y, 'Student Name (In English) :', fd.sNameEnglish ? fd.sNameEnglish.toUpperCase() : '', 45);
        drawField(rx, y, '(In Bangla) :', fd.sNameBangla || '', 40);
        rx = drawField(pw - M - 70, y, 'Blood Group :', fd.bloodGroup || '', 10);
        rx = drawField(rx, y, 'Religion :', fd.religion || '', 15);
        drawField(rx, y, 'Gender :', fd.gender || '', 12);
        y += 6.5;

        rx = drawField(M + 4, y, 'Date of Birth :', fd.dob || '', 20);
        rx = drawField(rx, y, 'Birth Registration No. :', fd.bitId || '', 30);
        rx = drawField(rx, y, 'Nationality :', fd.nationality || 'Bangladeshi', 20);
        rx = drawField(rx, y, 'Marital Status :', fd.maritalStatus || '', 15);
        drawField(rx, y, 'Mobile No :', fd.sMobileNo || '', 22);
        y += 6.5;

        endSection(sy);

        // ============================================
        // 2. Father's Information
        // ============================================
        sy = startSection("2. Father's Information");
        rx = drawField(M + 4, y, "Father's Name :", fd.fName ? fd.fName.toUpperCase() : '', 60);
        rx = drawField(rx, y, 'NID :', fd.fNid || '', 30);
        rx = drawField(rx, y, 'Qualification :', getNameById(lookups.qualifications, fd.fQualification) || '', 30);
        drawField(rx, y, 'Occupation :', getNameById(lookups.occupations, fd.fOccupation) || '', 25);
        y += 6.5;

        rx = drawField(M + 4, y, 'Income (Monthly) :', String(fd.fMonthlyIncome || ''), 20);
        rx = drawField(rx, y, '(Yearly) :', String((fd.fMonthlyIncome * 12) || ''), 20);
        drawField(rx, y, 'Mobile No :', fd.fMobileNo || '', 22);
        y += 6.5;
        endSection(sy);

        // ============================================
        // 3. Mother's Information
        // ============================================
        sy = startSection("3. Mother's Information");
        rx = drawField(M + 4, y, "Mother's Name :", fd.mName ? fd.mName.toUpperCase() : '', 60);
        rx = drawField(rx, y, 'NID :', fd.mNid || '', 30);
        rx = drawField(rx, y, 'Qualification :', getNameById(lookups.qualifications, fd.mQualification) || '', 30);
        drawField(rx, y, 'Occupation :', getNameById(lookups.occupations, fd.mOccupation) || '', 25);
        y += 6.5;

        rx = drawField(M + 4, y, 'Income (Monthly) :', String(fd.mMonthlyIncome || ''), 20);
        rx = drawField(rx, y, '(Yearly) :', String((fd.mMonthlyIncome * 12) || ''), 20);
        drawField(rx, y, 'Mobile No :', fd.mMobileNo || '', 22);
        y += 6.5;
        endSection(sy);

        // ============================================
        // 4. Total Yearly Income
        // ============================================
        sy = startSection("4. Total Yearly Income(Father's & Mother's):");
        doc.setFont('Bornomala', 'bold');
        doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
        const total = ((fd.fMonthlyIncome * 12) + (fd.mMonthlyIncome * 12)) || '';
        // Placed right after the title
        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.rect(M + 85, sy + 1, 30, 5);
        doc.text(String(total), M + 86, sy + 4.5);
        y -= 2; // adjust for inline layout of title
        endSection(sy);

        // ============================================
        // 5. Address
        // ============================================
        sy = startSection('5. Address');

        doc.setFontSize(8); doc.setTextColor(50, 50, 50); doc.setFont('Bornomala', 'normal');
        doc.text('Permanent Address:', M + 4, y + 4); y += 5.5;
        rx = drawField(M + 6, y, 'Vill/Block/Area :', fd.permanentAddressVil || '', 35);
        rx = drawField(rx, y, 'Post office :', fd.permanentAddressPO || '', 25);
        rx = drawField(rx, y, 'Thana :', fd.permanentAddressPS || '', 25);
        drawField(rx, y, 'District :', getNameById(lookups.districts, fd.permanentAddressDist) || '', 25);
        y += 6.5;

        doc.setFontSize(8); doc.setTextColor(50, 50, 50); doc.setFont('Bornomala', 'normal');
        doc.text('Present Address:', M + 4, y + 4); y += 5.5;
        rx = drawField(M + 6, y, 'Vill/Block/Area :', fd.presentAddressVil || '', 35);
        rx = drawField(rx, y, 'Post office :', fd.presentAddressPO || '', 25);
        rx = drawField(rx, y, 'Thana :', fd.presentAddressPS || '', 25);
        drawField(rx, y, 'District :', getNameById(lookups.districts, fd.presentAddressDist) || '', 25);
        y += 6.5;

        endSection(sy);

        // ============================================
        // 6. Guardian's Information
        // ============================================
        sy = startSection("6. Guardian's Information");
        rx = drawField(M + 4, y, "Guardian's Name :", fd.gName ? fd.gName.toUpperCase() : '', 60);
        rx = drawField(rx, y, 'NID :', fd.gNid || '', 30);
        rx = drawField(rx, y, 'Relation :', fd.gRelation || '', 20);
        drawField(rx, y, 'Mobile No :', fd.gMobileNo || '', 22);
        y += 6.5;

        rx = drawField(M + 4, y, 'E-mail :', fd.gEmail || '', 55);
        drawField(rx, y, 'Address :', fd.gAddress || '', 80);
        y += 6.5;
        endSection(sy);

        // ============================================
        // 7. Reference's Information
        // ============================================
        sy = startSection("7. Reference's Information");
        rx = drawField(M + 4, y, "Name :", fd.refName ? fd.refName.toUpperCase() : '', 60);
        rx = drawField(rx, y, 'NID :', fd.refNid || '', 30);
        rx = drawField(rx, y, 'Relation :', fd.refRelation || '', 20);
        drawField(rx, y, 'Mobile No :', fd.refMobileNo || '', 22);
        y += 6.5;
        drawField(M + 4, y, 'E-mail :', '', 55); // The image shows email & address, assume blank if not in fd
        drawField(M + 68, y, 'Address :', '', 80);
        y += 6.5;
        endSection(sy);

        // ============================================
        // 8. Educational Information
        // ============================================
        sy = startSection('8. Educational Information');
        rx = drawField(M + 4, y, 'Exam name :', 'SSC', 15);
        rx = drawField(rx, y, 'Roll No :', fd.rollNo1 || '', 18);
        rx = drawField(rx, y, 'Reg. No :', fd.regNo1 || '', 18);
        rx = drawField(rx, y, 'Session :', fd.sessionExam1 || '', 22);
        rx = drawField(rx, y, 'GPA :', fd.gpa1 || '', 12);
        rx = drawField(rx, y, 'Passing Year :', fd.passingYear1 || '', 15);
        drawField(rx, y, 'Board :', getNameById(lookups.boards, fd.Board1) || '', 25);
        y += 6.5;

        if (progName !== 'HSC') {
            rx = drawField(M + 4, y, 'Exam name :', 'HSC', 15);
            rx = drawField(rx, y, 'Roll No :', fd.rollNo2 || '', 18);
            rx = drawField(rx, y, 'Reg. No :', fd.regNo2 || '', 18);
            rx = drawField(rx, y, 'Session :', fd.sessionExam2 || '', 22);
            rx = drawField(rx, y, 'GPA :', fd.gpa2 || '', 12);
            rx = drawField(rx, y, 'Passing Year :', fd.passingYear2 || '', 15);
            drawField(rx, y, 'Board :', getNameById(lookups.boards, fd.Board2) || '', 25);
            y += 6.5;
        }
        endSection(sy);"""


section_dst = """        // ============================================
        // 1. Students Information
        // ============================================
        let sy = startSection('1. Students Information');
        cx = M + 4;
        layoutField('Student Name (In English) :', fd.sNameEnglish ? fd.sNameEnglish.toUpperCase() : '', 45);
        layoutField('(In Bangla) :', fd.sNameBangla || '', 40);
        layoutField('Blood Group :', fd.bloodGroup || '', 10);
        layoutField('Religion :', fd.religion || '', 15);
        layoutField('Gender :', fd.gender || '', 12);
        y += 8; cx = M + 4; // new line block 2
        layoutField('Date of Birth :', fd.dob || '', 20);
        layoutField('Birth Registration No. :', fd.bitId || '', 30);
        layoutField('Nationality :', fd.nationality || 'Bangladeshi', 20);
        layoutField('Marital Status :', fd.maritalStatus || '', 15);
        layoutField('Mobile No :', fd.sMobileNo || '', 22);
        y += 8;
        endSection(sy);

        // ============================================
        // 2. Father's Information
        // ============================================
        sy = startSection("2. Father's Information");
        cx = M + 4;
        layoutField("Father's Name :", fd.fName ? fd.fName.toUpperCase() : '', 60);
        layoutField('NID :', fd.fNid || '', 30);
        layoutField('Qualification :', getNameById(lookups.qualifications, fd.fQualification) || '', 30);
        layoutField('Occupation :', getNameById(lookups.occupations, fd.fOccupation) || '', 25);
        y += 8; cx = M + 4;
        layoutField('Income (Monthly) :', String(fd.fMonthlyIncome || ''), 20);
        layoutField('(Yearly) :', String((fd.fMonthlyIncome * 12) || ''), 20);
        layoutField('Mobile No :', fd.fMobileNo || '', 22);
        y += 8;
        endSection(sy);

        // ============================================
        // 3. Mother's Information
        // ============================================
        sy = startSection("3. Mother's Information");
        cx = M + 4;
        layoutField("Mother's Name :", fd.mName ? fd.mName.toUpperCase() : '', 60);
        layoutField('NID :', fd.mNid || '', 30);
        layoutField('Qualification :', getNameById(lookups.qualifications, fd.mQualification) || '', 30);
        layoutField('Occupation :', getNameById(lookups.occupations, fd.mOccupation) || '', 25);
        y += 8; cx = M + 4;
        layoutField('Income (Monthly) :', String(fd.mMonthlyIncome || ''), 20);
        layoutField('(Yearly) :', String((fd.mMonthlyIncome * 12) || ''), 20);
        layoutField('Mobile No :', fd.mMobileNo || '', 22);
        y += 8;
        endSection(sy);

        // ============================================
        // 4. Total Yearly Income
        // ============================================
        sy = startSection("4. Total Yearly Income(Father's & Mother's):");
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(11);
        doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
        const total = ((fd.fMonthlyIncome * 12) + (fd.mMonthlyIncome * 12)) || '';
        // Placed right after the title
        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.rect(M + 85, sy + 1, 30, 5);
        doc.text(String(total), M + 86, sy + 4.5);
        y -= 2; // adjust for inline layout of title
        endSection(sy);

        // ============================================
        // 5. Address
        // ============================================
        sy = startSection('5. Address');
        doc.setFontSize(11); doc.setTextColor(0, 0, 0); doc.setFont('Bornomala', 'normal');
        doc.text('Permanent Address:', M + 4, y + 4); y += 6.5;
        cx = M + 6;
        layoutField('Vill/Block/Area :', fd.permanentAddressVil || '', 35);
        layoutField('Post office :', fd.permanentAddressPO || '', 25);
        layoutField('Thana :', fd.permanentAddressPS || '', 25);
        layoutField('District :', getNameById(lookups.districts, fd.permanentAddressDist) || '', 25);
        y += 8;

        doc.setFontSize(11); doc.setTextColor(0, 0, 0); doc.setFont('Bornomala', 'normal');
        doc.text('Present Address:', M + 4, y + 4); y += 6.5;
        cx = M + 6;
        layoutField('Vill/Block/Area :', fd.presentAddressVil || '', 35);
        layoutField('Post office :', fd.presentAddressPO || '', 25);
        layoutField('Thana :', fd.presentAddressPS || '', 25);
        layoutField('District :', getNameById(lookups.districts, fd.presentAddressDist) || '', 25);
        y += 8;
        endSection(sy);

        // ============================================
        // 6. Guardian's Information
        // ============================================
        sy = startSection("6. Guardian's Information");
        cx = M + 4;
        layoutField("Guardian's Name :", fd.gName ? fd.gName.toUpperCase() : '', 60);
        layoutField('NID :', fd.gNid || '', 30);
        layoutField('Relation :', fd.gRelation || '', 20);
        layoutField('Mobile No :', fd.gMobileNo || '', 22);
        y += 8; cx = M + 4;
        layoutField('E-mail :', fd.gEmail || '', 55);
        layoutField('Address :', fd.gAddress || '', 80);
        y += 8;
        endSection(sy);

        // ============================================
        // 7. Reference's Information
        // ============================================
        sy = startSection("7. Reference's Information");
        cx = M + 4;
        layoutField("Name :", fd.refName ? fd.refName.toUpperCase() : '', 60);
        layoutField('NID :', fd.refNid || '', 30);
        layoutField('Relation :', fd.refRelation || '', 20);
        layoutField('Mobile No :', fd.refMobileNo || '', 22);
        y += 8; cx = M + 4;
        layoutField('E-mail :', '', 55); 
        layoutField('Address :', '', 80);
        y += 8;
        endSection(sy);

        // ============================================
        // 8. Educational Information
        // ============================================
        sy = startSection('8. Educational Information');
        cx = M + 4;
        layoutField('Exam name :', 'SSC', 15);
        layoutField('Roll No :', fd.rollNo1 || '', 18);
        layoutField('Reg. No :', fd.regNo1 || '', 18);
        layoutField('Session :', fd.sessionExam1 || '', 22);
        layoutField('GPA :', fd.gpa1 || '', 12);
        layoutField('Passing Year :', fd.passingYear1 || '', 15);
        layoutField('Board :', getNameById(lookups.boards, fd.Board1) || '', 25);
        y += 8; cx = M + 4;

        if (progName !== 'HSC') {
            layoutField('Exam name :', 'HSC', 15);
            layoutField('Roll No :', fd.rollNo2 || '', 18);
            layoutField('Reg. No :', fd.regNo2 || '', 18);
            layoutField('Session :', fd.sessionExam2 || '', 22);
            layoutField('GPA :', fd.gpa2 || '', 12);
            layoutField('Passing Year :', fd.passingYear2 || '', 15);
            layoutField('Board :', getNameById(lookups.boards, fd.Board2) || '', 25);
            y += 8;
        }
        endSection(sy);"""

content = content.replace(section_src, section_dst)

if layout_field_src in content:
    print("Replace SUCCESS!")
else:
    print("Replace FAILED! Source strings didn't align.")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)
