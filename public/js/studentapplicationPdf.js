/**
 * ============================================================
 * Student Application PDF Generator
 * ============================================================
 * Package:     studentapplicationPdf
 * Version:     1.0.0
 * Description: Generates a preview-style A4 PDF of a student
 *              admission application form using jsPDF.
 * Dependencies:
 *   - jsPDF v2.5.1 (https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js)
 * Font:        Bornomala (Regular + Bold) — loaded from /fonts/Bornomala/
 * Author:      Hazera-Taju Degree College
 * ============================================================
 */

// ── Helper: Convert hex color string to [r, g, b] array ──
function hexToRgb(hex) {
    hex = (hex || '#14532d').replace('#', '');
    return [
        parseInt(hex.substring(0, 2), 16),
        parseInt(hex.substring(2, 4), 16),
        parseInt(hex.substring(4, 6), 16)
    ];
}

// ── Helper: Convert an image URL to a base64 data URL ──
async function getImageDataUrl(url) {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth || 120;
            canvas.height = img.naturalHeight || 120;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            resolve(canvas.toDataURL('image/png'));
        };
        img.onerror = () => resolve(null);
        img.src = url;
    });
}

// ── Helper: Load Bornomala font (Regular + Bold) into jsPDF ──
async function loadBornomalaFont(doc) {
    try {
        const response = await fetch('/fonts/Bornomala/Bornomala-Regular.ttf');
        if (!response.ok) throw new Error('Font not found');
        const buffer = await response.arrayBuffer();
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.length; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        const base64 = btoa(binary);
        doc.addFileToVFS('Bornomala-Regular.ttf', base64);
        doc.addFont('Bornomala-Regular.ttf', 'Bornomala', 'normal');
        console.log('Bornomala font loaded successfully.');

        // Also load bold
        const boldResponse = await fetch('/fonts/Bornomala/Bornomala-Bold.ttf');
        if (boldResponse.ok) {
            const boldBuffer = await boldResponse.arrayBuffer();
            const boldBytes = new Uint8Array(boldBuffer);
            let boldBinary = '';
            for (let i = 0; i < boldBytes.length; i++) {
                boldBinary += String.fromCharCode(boldBytes[i]);
            }
            const boldBase64 = btoa(boldBinary);
            doc.addFileToVFS('Bornomala-Bold.ttf', boldBase64);
            doc.addFont('Bornomala-Bold.ttf', 'Bornomala', 'bold');
            console.log('Bornomala Bold font loaded.');
        }
    } catch (e) {
        console.warn('Could not load Bornomala font, falling back to default:', e.message);
    }
}

// ══════════════════════════════════════════════════════════════
// Main PDF Generation — Preview-style layout
// ──────────────────────────────────────────────────────────────
// @param {Object} formData   — Alpine.js formData object
// @param {Object} lookups    — { programs, groups, allSessions, qualifications,
//                                occupations, districts, boards, subjects }
// @param {Function} getNameById    — (list, id) => name
// @param {Function} getSubjectName — (id) => subject name string
// ══════════════════════════════════════════════════════════════
async function generateStudentApplicationPdf(formData, lookups, getNameById, getSubjectName) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');
    await loadBornomalaFont(doc);

    const pw = 210;           // page width mm
    var M = 0;            // 0.5mm margin
    const W = pw - 1;         // content width (pw - M*2)

    const clrBase = hexToRgb(formData.groupColor || '#14532d');

    // Dynamic Group Colors
    const clrHeaderBg = clrBase;         // Primary group color for main header
    const clrPinBg = clrBase;            // Same color for PIN row (or slightly distinct if preferred)
    const clrBorder = clrBase;           // Group color for section rounded borders
    const clrBoxOut = [150, 160, 170];   // Lighter grey outline for value boxes
    const clrTextVal = [0, 0, 0];        // Pure black for inserted values

    const fd = formData;
    let y = M;
    let cx = M + 3;

    // ── Drawing helpers ──────────────────────────
    // MANUAL EDIT: Adjust lineSpacing value to increase/decrease spacing between lines
    const lineSpacing = 6; // Default: 6mm - Increase to 7 or 8 for more space

    let fieldBuffer = [];

    function flushFields(startX = M + 3) {
        if (fieldBuffer.length === 0) return;
        const rightMarginX = pw - M - 6;
        let linesData = [];
        let currentLine = [];
        let currentLineWidth = 0;

        for (let i = 0; i < fieldBuffer.length; i++) {
            let f = fieldBuffer[i];
            doc.setFont('Bornomala', 'normal');
            doc.setFontSize(10);
            let lw = doc.getTextWidth(f.label) + 1;
            doc.setFont('Bornomala', 'bold');
            let textWidth = doc.getTextWidth(f.value);
            let vw = Math.max(textWidth + 4, f.baseW || 15);

            let advance = lw + vw + 3;
            let maxAvailableVW = rightMarginX - startX - lw - 1;
            if (vw > maxAvailableVW && maxAvailableVW > 10) {
                vw = Math.max(10, maxAvailableVW);
                advance = lw + vw + 3;
            }

            if (currentLine.length > 0 && currentLineWidth + advance - 3 > rightMarginX - startX) {
                linesData.push({ fields: currentLine, width: currentLineWidth - 3 });
                currentLine = [];
                currentLineWidth = 0;
            }

            f.lw = lw;
            f.textWidth = textWidth;
            f.minVw = vw;

            currentLine.push(f);
            currentLineWidth += advance;
        }
        if (currentLine.length > 0) {
            linesData.push({ fields: currentLine, width: currentLineWidth - 3 });
        }

        for (let l = 0; l < linesData.length; l++) {
            let line = linesData[l];
            let remainingSpace = rightMarginX - (startX + line.width);
            let extraPerField = 0;

            if (remainingSpace > 0 && line.fields.length > 0) {
                extraPerField = remainingSpace / line.fields.length;
            }

            cx = startX;
            let maxBoxHeight = 5;

            for (let i = 0; i < line.fields.length; i++) {
                let f = line.fields[i];
                f.finalVw = f.minVw + extraPerField;
                f.lines = [f.value];
                f.boxHeight = 5;
                if (f.textWidth > f.finalVw - 4) {
                    doc.setFont('Bornomala', 'bold');
                    f.lines = doc.splitTextToSize(f.value, Math.max(10, f.finalVw - 4));
                    f.boxHeight = Math.max(5, (f.lines.length * 4.5) + 0.5);
                }
                if (f.boxHeight > maxBoxHeight) maxBoxHeight = f.boxHeight;
            }

            for (let i = 0; i < line.fields.length; i++) {
                let f = line.fields[i];
                doc.setFont('Bornomala', 'normal');
                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);
                doc.text(f.label, cx, y + 4.2);
                const bx = cx + f.lw;
                doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
                doc.setLineWidth(0.2);
                doc.rect(bx, y + 0.5, f.finalVw, f.boxHeight);
                if (f.value) {
                    doc.setFont('Bornomala', 'bold');
                    doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
                    for (let j = 0; j < f.lines.length; j++) {
                        doc.text(f.lines[j], bx + 1.5, y + 4.2 + (j * 4.5));
                    }
                }
                cx = bx + f.finalVw + 3;
            }
            y += Math.max(lineSpacing, maxBoxHeight + 1);
        }
        cx = M + 3;
        fieldBuffer = [];
    }

    function layoutField(label, value, baseW = 0) {
        fieldBuffer.push({ label, value: value ? String(value) : '', baseW });
    }

    // Section wrapper: rounded border, title
    // MANUAL EDIT: Adjust sectionTitleSpacing to change space after section title
    const sectionTitleSpacing = 4.5; // Default: 4.5mm - Increase to 5 or 6 for more space

    function startSection(title) {
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(10);
        doc.setTextColor(10, 10, 10);

        const startY = y;
        // The rounded rect will be drawn at endSection, but title is placed now
        doc.text(title, M + 3, y + 3.5);
        y += sectionTitleSpacing;
        return startY;
    }

    // MANUAL EDIT: Adjust sectionBottomMargin to change space after each section
    const sectionBottomMargin = 3; // Default: 1.5mm - Increase to 2 or 3 for more space

    function endSection(startY) {
        flushFields();
        doc.setDrawColor(clrBorder[0], clrBorder[1], clrBorder[2]);
        doc.setLineWidth(0.5);
        // a rounded rectangle enclosing the section
        doc.roundedRect(M, startY, W, y - startY + 1.5, 2, 2);
        y += sectionBottomMargin; // space after section
    }

    try {
        // ============================================
        // HEADER
        // ============================================
        const hh = 33;
        doc.setFillColor(clrHeaderBg[0], clrHeaderBg[1], clrHeaderBg[2]);
        doc.rect(0, y, pw, hh, 'F');

        // Logo
        let logoDataUrl = null;
        try {
            const logoUrl = document.querySelector('#preview-content img[alt="Logo"]')?.src;
            if (logoUrl) {
                logoDataUrl = await getImageDataUrl(logoUrl);
                if (logoDataUrl) doc.addImage(logoDataUrl, 'PNG', M + 2, y + 2, 30, 30);
            }
        } catch (e) { }

        // Center text
        doc.setTextColor(0, 0, 0); // Black text on colored header
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(18);
        doc.text('HAZERA-TAJU DEGREE COLLEGE', pw / 2, y + 8, { align: 'center' });
        doc.setFont('Bornomala', 'normal');
        doc.setFontSize(12);
        doc.text('B.Sc Chattar, Chandgaon, Chattogram', pw / 2, y + 13, { align: 'center' });
        doc.setFont('Bornomala', 'bold'); // Bold for this line
        doc.setFontSize(12);
        const progName = getNameById(lookups.programs, fd.program);
        doc.text(`Application Form For ${progName || 'Admission'} Admission`, pw / 2, y + 17, { align: 'center' });

        doc.setFontSize(14);
        doc.setTextColor(0, 0, 0);
        doc.text(`${getNameById(lookups.groups, fd.group) || ''} Group`, pw / 2, y + 26, { align: 'center' });
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0);
        doc.text(`Session : ${getNameById(lookups.admissionSessions, fd.session) || '20XX-20XX'}`, pw / 2, y + 31, { align: 'center' });

        // Student photo (box with placeholder or image)
        const photoSize = 32;
        const photoX = pw - M - photoSize;
        const photoY = y;
        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.setLineWidth(0.2);
        doc.rect(photoX, photoY, photoSize, photoSize);
        if (fd.imagePreview && !fd.imagePreview.includes('placehold.co')) {
            try { doc.addImage(fd.imagePreview, 'JPEG', photoX, photoY, photoSize, photoSize); } catch (e) { }
        }
        y += hh;
        y += 0.5;
        // ============================================
        // PIN / DATE / CLASS ROLL row
        // ============================================
        const prh = 7;
        doc.setFillColor(clrPinBg[0], clrPinBg[1], clrPinBg[2]);
        doc.rect(0, y, pw, prh, 'F');
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(12);
        doc.setTextColor(0, 0, 0); // Black text

        // PIN
        doc.text(`PIN CODE: ${fd.pinCode || 'XXXXXX'}`, M + 2, y + 5);

        // Date
        doc.setFontSize(12);
        doc.setFont('Bornomala', 'normal');
        doc.text('Admission Date :', pw / 2 - 30, y + 5);
        // Draw white background first
        doc.setFillColor(255, 255, 255); // White background
        doc.rect(pw / 2, y + 0.5, 35, 6, 'F'); // Fill with white

        // Class Roll
        doc.setFontSize(12);
        doc.setFont('Bornomala', 'normal');
        doc.setTextColor(0, 0, 0);
        doc.text('Class Roll :', pw - M - 40, y + 5);

        // Draw white background for Class Roll box (positioned on the right)
        doc.setFillColor(255, 255, 255); // White background
        const classRollX = pw - M - 18; // Position on the right side
        doc.rect(classRollX, y + 0.5, 15, 6, 'F'); // Fill with white

        y += prh + 1; // Gap before sections
        M = 0.6;

        // ============================================
        // BACKGROUND WATERMARK LOGO
        // ============================================
        if (logoDataUrl) {
            doc.setGState(new doc.GState({ opacity: 0.1 }));
            doc.addImage(logoDataUrl, 'PNG', 55, 100, 100, 100);
            doc.setGState(new doc.GState({ opacity: 1.0 }));
        }

        // ============================================
        // 1. Students Information
        // ============================================
        let sy = startSection('1. Students Information');
        cx = M + 3;
        layoutField('Student Name (In English) :', fd.sNameEnglish ? fd.sNameEnglish.toUpperCase() : '', 45);
        layoutField('(In Bangla) :', fd.sNameBangla || '', 40);
        layoutField('Blood Group :', fd.bloodGroup || '', 10);
        layoutField('Religion :', fd.religion || '', 15);
        layoutField('Gender :', fd.gender || '', 12);

        layoutField('Date of Birth :', fd.dob || '', 20);
        layoutField('Birth Registration No. :', fd.bitId || '', 30);
        layoutField('Nationality :', fd.nationality || 'Bangladeshi', 20);
        layoutField('Marital Status :', fd.maritalStatus || '', 15);
        layoutField('Mobile No :', fd.sMobileNo || '', 22);
        layoutField('NID :', fd.nid || '', 30);
        layoutField('Hobby :', fd.hobby || '', 20);
        layoutField('Extra Curricular :', fd.extracurriculam || fd.extraCurricular || '', 30);

        endSection(sy);


        // ============================================
        // 2. Father's Information
        // ============================================
        sy = startSection("2. Father's Information");
        cx = M + 3;
        layoutField("Father's Name :", fd.fName ? fd.fName.toUpperCase() : '', 60);
        layoutField('NID :', fd.fNid || '', 30);
        layoutField('Qualification :', getNameById(lookups.qualifications, fd.fQualification) || '', 30);
        layoutField('Occupation :', getNameById(lookups.occupations, fd.fOccupation) || '', 25);

        layoutField('Income (Monthly) :', String(fd.fMonthlyIncome || ''), 20);
        layoutField('(Yearly) :', String((fd.fMonthlyIncome * 12) || ''), 20);
        layoutField('Mobile No :', fd.fMobileNo || '', 22);
        endSection(sy);



        // ============================================
        // 3. Mother's Information
        // ============================================
        sy = startSection("3. Mother's Information");
        cx = M + 3;
        layoutField("Mother's Name :", fd.mName ? fd.mName.toUpperCase() : '', 60);
        layoutField('NID :', fd.mNid || '', 30);
        layoutField('Qualification :', getNameById(lookups.qualifications, fd.mQualification) || '', 30);
        layoutField('Occupation :', getNameById(lookups.occupations, fd.mOccupation) || '', 25);

        layoutField('Income (Monthly) :', String(fd.mMonthlyIncome || ''), 20);
        layoutField('(Yearly) :', String((fd.mMonthlyIncome * 12) || ''), 20);
        layoutField('Mobile No :', fd.mMobileNo || '', 22);
        endSection(sy);



        // ============================================
        // 4. Total Yearly Income
        // ============================================
        sy = startSection("4. Total Yearly Income(Father's & Mother's):");
        doc.setFont('Bornomala', 'bold');
        doc.setFontSize(10);
        doc.setTextColor(clrTextVal[0], clrTextVal[1], clrTextVal[2]);
        const total = ((fd.fMonthlyIncome * 12) + (fd.mMonthlyIncome * 12)) || '';
        // Placed dynamically right after the title width calculation
        let titleW = doc.getTextWidth("4. Total Yearly Income(Father's & Mother's):");
        doc.setDrawColor(clrBoxOut[0], clrBoxOut[1], clrBoxOut[2]);
        doc.rect(M + 3 + titleW + 2, sy + 0.5, 30, 5);
        doc.text(String(total), M + 3 + titleW + 3.5, sy + 4.2);
        y += 1; // adjust for inline layout of title
        endSection(sy);



        // ============================================
        // 5. Address
        // ============================================
        sy = startSection('5. Address');

        doc.setFontSize(10); doc.setTextColor(0, 0, 0); doc.setFont('Bornomala', 'normal');
        doc.text('Permanent Address:', M + 4, y + 4); y += 6;
        cx = M + 6;
        layoutField('Vill/Block/Area :', fd.permanentAddressVil || '', 35);
        layoutField('Post office :', fd.permanentAddressPO || '', 25);
        layoutField('Thana :', fd.permanentAddressPS || '', 25);
        layoutField('District :', getNameById(lookups.districts, fd.permanentAddressDist) || '', 25);
        flushFields();
        y += 2;

        doc.setFontSize(10); doc.setTextColor(0, 0, 0); doc.setFont('Bornomala', 'normal');
        doc.text('Present Address:', M + 4, y + 4); y += 6;
        cx = M + 6;
        layoutField('Vill/Block/Area :', fd.presentAddressVil || '', 35);
        layoutField('Post office :', fd.presentAddressPO || '', 25);
        layoutField('Thana :', fd.presentAddressPS || '', 25);
        layoutField('District :', getNameById(lookups.districts, fd.presentAddressDist) || '', 25);

        endSection(sy);



        // ============================================
        // 6. Guardian's Information
        // ============================================
        sy = startSection("6. Guardian's Information");
        cx = M + 3;
        layoutField("Guardian's Name :", fd.gName ? fd.gName.toUpperCase() : '', 60);
        layoutField('NID :', fd.gNid || '', 30);
        layoutField('Relation :', fd.gRelation || '', 20);
        layoutField('Mobile No :', fd.gMobileNo || '', 22);

        layoutField('E-mail :', fd.gEmail || '', 55);
        layoutField('Address :', fd.gAddress || '', 80);
        endSection(sy);



        // ============================================
        // 7. Reference's Information
        // ============================================
        sy = startSection("7. Reference's Information");
        cx = M + 3;
        layoutField("Name :", fd.refName ? fd.refName.toUpperCase() : '', 60);
        layoutField('NID :', fd.refNid || '', 30);
        layoutField('Relation :', fd.refRelation || '', 20);
        layoutField('Mobile No :', fd.refMobileNo || '', 22);
        layoutField('E-mail :', fd.refEmail || '', 55);
        layoutField('Address :', '', 80);
        endSection(sy);



        // ============================================
        // 8. Educational Information
        // ============================================
        sy = startSection('8. Educational Information');
        cx = M + 3;
        layoutField('Exam name :', 'SSC', 15);
        layoutField('Roll No :', fd.rollNo1 || '', 18);
        layoutField('Reg. No :', fd.regNo1 || '', 18);
        layoutField('Session :', fd.sessionExam1 || '', 22);
        layoutField('GPA :', fd.gpa1 || '', 12);
        layoutField('Passing Year :', fd.passingYear1 || '', 15);
        layoutField('Board :', getNameById(lookups.boards, fd.Board1) || '', 25);
        flushFields();
        y += 2; cx = M + 3;

        const selectedProg = lookups.programs ? lookups.programs.find(p => p.id == fd.program) : null;
        const hscEnabled = selectedProg ? (selectedProg.hscStatus == 1 || selectedProg.hscStatus === true) : false;

        if (hscEnabled) {
            layoutField('Exam name :', 'HSC', 15);
            layoutField('Roll No :', fd.rollNo2 || '', 18);
            layoutField('Reg. No :', fd.regNo2 || '', 18);
            layoutField('Session :', fd.sessionExam2 || '', 22);
            layoutField('GPA :', fd.gpa2 || '', 12);
            layoutField('Passing Year :', fd.passingYear2 || '', 15);
            layoutField('Board :', getNameById(lookups.boards, fd.Board2) || '', 25);
        }
        endSection(sy);



        // ============================================
        // 8/9. Subject Information
        // ============================================
        if (!hscEnabled) {
            sy = startSection('8. Subject Information'); // Image shows 8. Subject Information

            doc.setFont('Bornomala', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(10, 10, 10);

            // Compulsory
            doc.text('Compulsory Subject :', M + 6, y + 4);
            doc.setFont('Bornomala', 'normal');
            doc.setTextColor(50, 50, 50);
            doc.text(`i. ${getSubjectName(fd.compulsory1) || ''}`, M + 6, y + 8);
            doc.text(`ii. ${getSubjectName(fd.compulsory2) || ''}`, M + 6, y + 12);
            doc.text(`iii. ${getSubjectName(fd.compulsory3) || ''}`, M + 6, y + 16);

            // Elective
            let sx2 = M + 50;
            doc.setFont('Bornomala', 'bold');
            doc.setTextColor(10, 10, 10);
            doc.text('Elective Subject :', sx2, y + 4);
            doc.setFont('Bornomala', 'normal');
            doc.setTextColor(50, 50, 50);
            doc.text(`iv. ${getSubjectName(fd.elective1) || ''}`, sx2, y + 8);
            doc.text(`v. ${getSubjectName(fd.elective2) || ''}`, sx2, y + 12);
            doc.text(`vi. ${getSubjectName(fd.elective3) || ''}`, sx2, y + 16);

            // Optional
            let sx3 = M + 145;
            doc.setFont('Bornomala', 'bold');
            doc.setTextColor(10, 10, 10);
            doc.text('Optional Subject :', sx3, y + 4);
            doc.setFont('Bornomala', 'normal');
            doc.setTextColor(50, 50, 50);
            doc.text(`vii. ${getSubjectName(fd.optional) || ''}`, sx3, y + 8);

            y += 16;
            endSection(sy);
        }


        y += 2;

        // ============================================
        // FOOTER
        // ============================================
        doc.setFontSize(7);
        doc.setTextColor(50, 50, 50);
        doc.setFont('Bornomala', 'normal');
        doc.text('Page-1', pw / 2, y + 2, { align: 'center' });

        // ============================================
        // 2ND PAGE - TERMS IMAGE (If enabled)
        // ============================================
        const prog = lookups.programs ? lookups.programs.find(p => p.id == fd.program) : null;
        const isTermsEnabled = prog && (
            prog.termsImageStatus == 1 || prog.termsImageStatus === true ||
            prog.terimageStatus == 1 || prog.terimageStatus === true ||
            prog.terms_image_status == 1 || prog.terms_image_status === true ||
            prog.terimage_status == 1 || prog.terimage_status === true
        );

        if (isTermsEnabled) {
            let tImgUrl = prog.termsImage || prog.termimage || prog.terms_image || prog.terimage || prog.terms_image_url || prog.terimage_url;
            if (tImgUrl) {
                if (!tImgUrl.startsWith('http') && !tImgUrl.startsWith('/') && !tImgUrl.startsWith('data:')) {
                    tImgUrl = '/storage/' + tImgUrl;
                }
                const tLd = await getImageDataUrl(tImgUrl);
                if (tLd) {
                    doc.addPage();
                    doc.addImage(tLd, 'JPEG', 0, 0, 210, 297); // Full A4
                }
            }
        }

        // Save
        const filename = `Admission_Form_${(fd.pinCode || fd.sNameEnglish || 'Application').replace(/\s+/g, '_')}.pdf`;
        doc.save(filename);

    } catch (err) {
        console.error('PDF generation failed:', err);
        alert('PDF generation failed: ' + err.message);
    }
}
