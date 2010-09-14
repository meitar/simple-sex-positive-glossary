<?php
/*
Plugin Name: Simple Sex-Positive Glossary
Version: 0.1
Plugin URI: Wraps common terms with a link to a definition of that term. Built-in dictionary provides defaults for many sexuality-related phrases.
Description: Wraps common terms with a link to a definition of that term.
Author: Meitar "maymay" Moscovitz
Author URI: http://maybemaimed.com/

Copyright (c) 2010
Released under the GPL license
http://www.gnu.org/licenses/gpl.txt

This work is based off the WP Acronym Replacer plugin by Joel Bennett.
Joel's URI: http://www.HuddledMasses.org

    This file is part of WordPress.
    WordPress is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * function sexPositiveGlossaryTerm
 *
 * Given a string, finds and replaces all known terms with links pointing to a
 * page that provides their definition.
 *
 * @return string The replaced text.
 * @see http://www.maxprograms.com/articles/glossml.html
 */
function sexPositiveGlossaryTerm($text) {
    // First, we define all the things we're going to replace, without using parenthesis or pipes (|)
    // each deffinition is in the form: // "term" => "URL",
    // where URL is a fully-qualified link to a page where that term is defined.
    // For example:
    //         "afaik" => "http://www.acronymfinder.com/AFAIK.html",
    // ESPECIALLY note that they all end with commas EXCEPT the last one
    global $sexpositiveterm_sexpositiveterm;

    if (empty($sexpositiveterm_sexpositiveterm)) {
        $sexpositiveterm_sexpositiveterm = array(
            // If we need to define an actual regex, we create a new array here.
            // key is the search pattern, value is the acronym expansion
            // Be certain to include a full-match parenthesis boundary for the replacement!
            array("(Sex Work(ers?)?)" => "http://sexuality.about.com/od/glossary/g/sex_work.htm"),
            "AIDS" => "http://www.scarleteen.com/glossary/term/3415",
            "ASFR" => "http://sexuality.about.com/od/glossary/g/asfr.htm",
            "Abstinence" => "http://sexuality.about.com/od/glossary/g/abstinence.htm",
            "Acrotomophilia" => "http://sexuality.about.com/od/glossary/g/Acrotomophilia.htm",
            "Agalmatophilia" => "http://sexuality.about.com/od/glossary/g/agalmatophilia.htm",
            "Agoraphilia" => "http://sexuality.about.com/od/glossary/g/Agoraphilia.htm",
            "Anal Beads" => "http://sexuality.about.com/od/sextoys/a/anal_beads.htm",
            "Anal Dildo" => "http://sexuality.about.com/od/sextoys/a/anal_dildo.htm",
            "Analingus" => "http://sexuality.about.com/od/glossary/g/analingus.htm",
            "Anorgasmia" => "http://sexuality.about.com/od/glossary/g/anorgasmia.htm",
            "Asexual" => "http://sexuality.about.com/od/glossary/g/asexual.htm",
            "Asphyxiophilia" => "http://sexuality.about.com/od/glossary/g/asphyxiophilia.htm",
            "Autofellatio" => "http://sexuality.about.com/od/glossary/g/autofellatio.htm",
            "Avatar" => "http://sexuality.about.com/od/glossary/g/avatar.htm",
            "BDSM" => "http://sexuality.about.com/od/glossary/g/BDSM.htm",
            //"BDSM" => "http://www.scarleteen.com/glossary/term/3452",
            "Bacterial vaginosis" => "http://www.scarleteen.com/glossary/term/3407",
            "Bestiality" => "http://sexuality.about.com/od/glossary/g/bestiality.htm",
            "Bot" => "http://sexuality.about.com/od/glossary/g/bot.htm",
            "Butt Plugs" => "http://sexuality.about.com/od/sextoys/a/butt_plugs.htm",
            "Candaulism" => "http://sexuality.about.com/od/glossary/g/Candaulism.htm",
            "Casual Sex" => "http://sexuality.about.com/od/glossary/g/casual_sex.htm",
            "Certified Sexuality Educator" => "http://sexuality.about.com/od/glossary/g/certified_sexuality_educator.htm",
            "Chlamydia" => "http://sexuality.about.com/od/glossary/g/chlamydia.htm",
            //"Chlamydia" => "http://www.scarleteen.com/glossary/term/3408",
            "Coccinelle" => "http://sexuality.about.com/od/glossary/g/Coccinelle.htm",
            "Coitus" => "http://sexuality.about.com/od/glossary/g/coitus.htm",
            "Coprophilia" => "http://sexuality.about.com/od/glossary/g/coprophilia.htm",
            "Cuckold" => "http://sexuality.about.com/od/glossary/g/cuckold.htm",
            "Cuddle Party" => "http://sexuality.about.com/od/glossary/g/cuddleparty.htm",
            "Cytomegalovirus" => "http://www.scarleteen.com/glossary/term/3409",
            "DSM" => "http://sexuality.about.com/od/glossary/g/DSM.htm",
            "Dental Dam" => "http://sexuality.about.com/od/glossary/g/dental_dam.htm",
            "Devotees" => "http://sexuality.about.com/od/glossary/g/devotees.htm",
            "Dildo" => "http://sexuality.about.com/od/glossary/g/dildo.htm",
            "Dual Action Vibrator" => "http://sexuality.about.com/od/glossary/g/dual_action_vib.htm",
            "Dysparuenia" => "http://sexuality.about.com/od/glossary/g/dysparuenia.htm",
            "Edging" => "http://sexuality.about.com/od/glossary/g/edging.htm",
            "Emergent sex" => "http://sexuality.about.com/od/glossary/g/emergent_sex.htm",
            "Erectile Dysfunction" => "http://sexuality.about.com/od/glossary/g/erectiledysfunc.htm",
            "Erotophilia and Erotophobia" => "http://sexuality.about.com/od/glossary/g/erotophilia.htm",
            "FAM" => "http://www.scarleteen.com/glossary/term/3481",
            "FWB" => "http://www.scarleteen.com/glossary/term/3464",
            "Female Orgasmic Disorder" => "http://sexuality.about.com/od/glossary/g/female_orgasmic.htm",
            "Female Sexual Dysfunction" => "http://sexuality.about.com/od/glossary/g/female_sexual_dysfunction.htm",
            "Female genital cosmetic surgery" => "http://sexuality.about.com/od/glossary/g/female_surgery.htm",
            "Fetish" => "http://sexuality.about.com/od/glossary/g/fetish.htm",
            "Frenulum Breve" => "http://sexuality.about.com/od/glossary/g/frenulum_breve.htm",
            "G-spot" => "http://www.scarleteen.com/glossary/term/3377",
            "GLBT" => "http://www.scarleteen.com/glossary/term/3357",
            "Genetic Determinism" => "http://sexuality.about.com/od/glossary/g/genetic_determ.htm",
            "Genital Herpes" => "http://sexuality.about.com/od/glossary/g/genital_herpes.htm",
            "Gonorrhea" => "http://www.scarleteen.com/glossary/term/3410",
            "HIV" => "http://www.scarleteen.com/glossary/term/3414",
            "HPV" => "http://www.scarleteen.com/glossary/term/3416",
            "HSDD" => "http://sexuality.about.com/od/glossary/g/hsdd.htm",
            "Hepatitis" => "http://www.scarleteen.com/glossary/term/3412",
            "Herpes" => "http://www.scarleteen.com/glossary/term/3413",
            "Hypersexual Disorder" => "http://sexuality.about.com/od/glossary/g/hypersexual_disorder.htm",
            "IUD" => "http://www.scarleteen.com/glossary/term/3437",
            "Intercourse" => "http://sexuality.about.com/od/glossary/g/intercourse.htm",
            "Kegel Exercises" => "http://sexuality.about.com/od/glossary/g/kegelexercises.htm",
            "Kinsey Scale" => "http://sexuality.about.com/od/glossary/g/Kinsey-Scale.htm",
            "Klismaphilia" => "http://sexuality.about.com/od/glossary/g/klismaphilia.htm",
            "LGBT" => "http://www.scarleteen.com/glossary/term/3358",
            "LGBTQ" => "http://www.scarleteen.com/glossary/term/3359",
            "Labiaplasty" => "http://sexuality.about.com/od/glossary/g/labiaplasty.htm",
            "Lichen Sclerosus" => "http://sexuality.about.com/od/glossary/g/Lichensclerosus.htm",
            "Male Orgasmic Disorder" => "http://sexuality.about.com/od/glossary/g/male_orgasmic.htm",
            "Male Strap On" => "http://sexuality.about.com/od/glossary/g/male_strap_on.htm",
            "Male Vibrator" => "http://sexuality.about.com/od/malesextoys/g/Male-Vibrator.htm",
            "Marital Aids" => "http://sexuality.about.com/od/glossary/g/Marital-Aids.htm",
            "Masturbation" => "http://sexuality.about.com/od/glossary/g/masturbation.htm",
            "Non Ejaculatory Orgasm" => "http://sexuality.about.com/od/glossary/g/nonejacorgasm.htm",
            "Non-Monogamy" => "http://sexuality.about.com/od/glossary/g/nonmonogamy.htm",
            "OB/GYN" => "http://www.scarleteen.com/glossary/term/3387",
            "Oral Sex Taste" => "http://sexuality.about.com/od/glossary/g/oral_sex_taste.htm",
            "PC Muscle" => "http://sexuality.about.com/od/glossary/g/pcmuscles.htm",
            "PGAD" => "http://sexuality.about.com/od/glossary/g/pgad.htm",
            "PID" => "http://www.scarleteen.com/glossary/term/3411",
            "PSAS" => "http://sexuality.about.com/od/glossary/g/psas.htm",
            "Pansexual" => "http://sexuality.about.com/od/glossary/g/pansexual.htm",
            "Paraphilias" => "http://sexuality.about.com/od/glossary/g/paraphilias.htm",
            "Penile Dysmorphophobia" => "http://sexuality.about.com/od/glossary/g/small_penis.htm",
            "Penile Prosthesis" => "http://sexuality.about.com/od/glossary/g/penile_prosthesis.htm",
            "Penis Limiter" => "http://sexuality.about.com/od/glossary/g/penis_limiter.htm",
            "Penis Pumps" => "http://sexuality.about.com/od/glossary/g/penis_pumps.htm",
            "Perineum" => "http://sexuality.about.com/od/glossary/g/perineum.htm",
            "Phimosis" => "http://sexuality.about.com/od/glossary/g/Phimosis.htm",
            "Phthalates" => "http://sexuality.about.com/od/glossary/g/phthalates.htm",
            "Play Piercing" => "http://sexuality.about.com/od/glossary/g/Play-Piercing.htm",
            "Pre-cum" => "http://sexuality.about.com/od/glossary/g/precum.htm",
            "Premature Ejaculation" => "http://sexuality.about.com/od/glossary/g/premature_ejacu.htm",
            "Priapism" => "http://sexuality.about.com/od/glossary/g/priapism_def.htm",
            "Public Display of Affection" => "http://sexuality.about.com/od/glossary/g/public_display_of_affection.htm",
            "Rainbow Parties" => "http://sexuality.about.com/od/glossary/g/rainbowparty.htm",
            "Refractory Period" => "http://sexuality.about.com/od/glossary/g/refratoryperiod.htm",
            "Romantic product salesmen" => "http://sexuality.about.com/od/glossary/g/romanticproduct.htm",
            "STI" => "http://www.scarleteen.com/glossary/term/3349",
            "Scabies" => "http://www.scarleteen.com/glossary/term/3417",
            "Sex Coach" => "http://sexuality.about.com/od/glossary/g/sex-coach.htm",
            "Sex Drive" => "http://sexuality.about.com/od/glossary/g/sex_drive.htm",
            "Sex Educator" => "http://sexuality.about.com/od/glossary/g/sex_educator.htm",
            "Sex Positive" => "http://sexuality.about.com/od/glossary/g/sex_positive.htm",
            "Sex Professional" => "http://sexuality.about.com/od/glossary/g/sex-professional.htm",
            "Sex Researcher" => "http://sexuality.about.com/od/glossary/g/sex-researcher.htm",
            "Sex Tech" => "http://sexuality.about.com/od/glossary/g/sex_tech.htm",
            "Sex Therapist" => "http://sexuality.about.com/od/glossary/g/sex-therapist.htm",
            "Sex Toy" => "http://sexuality.about.com/od/glossary/g/sex_toys.htm",
            "Sexologist" => "http://sexuality.about.com/od/glossary/g/sexologist.htm",
            "Sexology" => "http://sexuality.about.com/od/glossary/g/sexology.htm",
            "Sexual Behavior" => "http://sexuality.about.com/od/glossary/g/sexual_behavior.htm",
            "Sexual Compatibility" => "http://sexuality.about.com/od/glossary/g/sexual_compatibility.htm",
            "Sexual Dysfunction" => "http://sexuality.about.com/od/glossary/g/sexual_dysfunction.htm",
            "Sexual Health" => "http://sexuality.about.com/od/glossary/g/sexual_health.htm",
            "Sexual Identity" => "http://sexuality.about.com/od/glossary/g/sexual_identity.htm",
            "Sexual Intimacy" => "http://sexuality.about.com/od/glossary/g/sexual_intimacy.htm",
            "Sexual Orientation" => "http://sexuality.about.com/od/glossary/g/sexualorientata.htm",
            "Sexual Problem" => "http://sexuality.about.com/od/glossary/g/sexual_problem.htm",
            "Sexual Surrogates" => "http://sexuality.about.com/od/glossary/g/sex_surrogates.htm",
            "Small Penis Syndrome" => "http://sexuality.about.com/od/glossary/g/small_penis_syn.htm",
            "Swinging" => "http://sexuality.about.com/od/glossary/g/Swinging.htm",
            "Syphilis" => "http://www.scarleteen.com/glossary/term/3418",
            "Teledildonics" => "http://sexuality.about.com/od/glossary/g/teledildonics_.htm",
            "Trichomoniasis" => "http://www.scarleteen.com/glossary/term/3419",
            "Uncircumcise" => "http://sexuality.about.com/od/glossary/g/Uncircumcise.htm",
            "Vacuum Pumps" => "http://sexuality.about.com/od/glossary/g/vacuum_pumps.htm",
            "Vaginoplasty" => "http://sexuality.about.com/od/glossary/g/vaginoplasty.htm",
            "Vasocongestion" => "http://sexuality.about.com/od/glossary/g/vasocongestion.htm",
            "Vibrator" => "http://sexuality.about.com/od/glossary/g/vibrator.htm",
            "Virtual Sex" => "http://sexuality.about.com/od/glossary/g/virtual_sex.htm",
            "XX" => "http://www.scarleteen.com/glossary/term/3523",
            "XY" => "http://www.scarleteen.com/glossary/term/3524",
            "Zoophilia" => "http://sexuality.about.com/od/glossary/g/zoophilia.htm",
            "abortion" => "http://www.scarleteen.com/glossary/term/3309",
            "abuse" => "http://www.scarleteen.com/glossary/term/3401",
            "adults" => "http://www.scarleteen.com/glossary/term/3404",
            "affection" => "http://www.scarleteen.com/glossary/term/3510",
            "age of consent" => "http://www.scarleteen.com/glossary/term/3531",
            "age-disparate" => "http://www.scarleteen.com/glossary/term/3466",
            "agender" => "http://www.scarleteen.com/glossary/term/3472",
            "aggressive" => "http://www.scarleteen.com/glossary/term/3398",
            "anal intercourse" => "http://www.scarleteen.com/glossary/term/3335",
            "anal sex" => "http://www.scarleteen.com/glossary/term/3331",
            "analingus" => "http://www.scarleteen.com/glossary/term/3522",
            "anatomy" => "http://www.scarleteen.com/glossary/term/3337",
            "androgyny" => "http://www.scarleteen.com/glossary/term/3470",
            "anus" => "http://www.scarleteen.com/glossary/term/3326",
            "aromantic" => "http://www.scarleteen.com/glossary/term/3473",
            "arousal" => "http://www.scarleteen.com/glossary/term/3508",
            "asexual" => "http://www.scarleteen.com/glossary/term/3360",
            "assertive" => "http://www.scarleteen.com/glossary/term/3397",
            "autonomy" => "http://www.scarleteen.com/glossary/term/3379",
            "binary" => "http://www.scarleteen.com/glossary/term/3499",
            "biphobia" => "http://www.scarleteen.com/glossary/term/3367",
            "birth control" => "http://www.scarleteen.com/glossary/term/3438",
            "bisexual" => "http://www.scarleteen.com/glossary/term/3343",
            "blastocyst" => "http://www.scarleteen.com/glossary/term/3494",
            "blue balls" => "http://www.scarleteen.com/glossary/term/3483",
            "body image" => "http://www.scarleteen.com/glossary/term/3525",
            "breast" => "http://www.scarleteen.com/glossary/term/3457",
            "butch" => "http://www.scarleteen.com/glossary/term/3432",
            "celibate" => "http://www.scarleteen.com/glossary/term/3474",
            "cervical barrier" => "http://www.scarleteen.com/glossary/term/3441",
            "cervix" => "http://www.scarleteen.com/glossary/term/3459",
            "cherry" => "http://www.scarleteen.com/glossary/term/3475",
            "cis gender" => "http://www.scarleteen.com/glossary/term/3303",
            "classism" => "http://www.scarleteen.com/glossary/term/3469",
            "clean" => "http://www.scarleteen.com/glossary/term/3527",
            "clitoris" => "http://www.scarleteen.com/glossary/term/3347",
            "coming out" => "http://www.scarleteen.com/glossary/term/3345",
            "communication" => "http://www.scarleteen.com/glossary/term/3462",
            "conception" => "http://www.scarleteen.com/glossary/term/3391",
            "condom" => "http://www.scarleteen.com/glossary/term/3356",
            "consent" => "http://www.scarleteen.com/glossary/term/3340",
            "contraception" => "http://www.scarleteen.com/glossary/term/3402",
            "corona" => "http://www.scarleteen.com/glossary/term/3460",
            "crura" => "http://www.scarleteen.com/glossary/term/3373",
            "cunnilingus" => "http://www.scarleteen.com/glossary/term/3520",
            "cute little dog" => "http://www.scarleteen.com/glossary/term/3434",
            "cybersex" => "http://www.scarleteen.com/glossary/term/3450",
            "dental dam" => "http://www.scarleteen.com/glossary/term/3519",
            "desire" => "http://www.scarleteen.com/glossary/term/3393",
            "discharge" => "http://www.scarleteen.com/glossary/term/3489",
            "dry sex" => "http://www.scarleteen.com/glossary/term/3386",
            "effectiveness" => "http://www.scarleteen.com/glossary/term/3389",
            "ejaculation" => "http://www.scarleteen.com/glossary/term/3449",
            "embryo" => "http://www.scarleteen.com/glossary/term/3495",
            "emergency contraception" => "http://www.scarleteen.com/glossary/term/3517",
            "enact" => "http://www.scarleteen.com/glossary/term/3573",
            "endometrium" => "http://www.scarleteen.com/glossary/term/3492",
            "entry" => "http://www.scarleteen.com/glossary/term/3383",
            "erection" => "http://www.scarleteen.com/glossary/term/3376",
            "erogenous zones" => "http://www.scarleteen.com/glossary/term/3355",
            "erotica" => "http://www.scarleteen.com/glossary/term/3516",
            "estrogen" => "http://www.scarleteen.com/glossary/term/3447",
            "exclusive" => "http://www.scarleteen.com/glossary/term/3512",
            "fallopian tubes" => "http://www.scarleteen.com/glossary/term/3488",
            "fellatio" => "http://www.scarleteen.com/glossary/term/3521",
            "feminine" => "http://www.scarleteen.com/glossary/term/3455",
            "femme" => "http://www.scarleteen.com/glossary/term/3530",
            "fetus" => "http://www.scarleteen.com/glossary/term/3496",
            "fisting" => "http://www.scarleteen.com/glossary/term/3477",
            "foreplay" => "http://www.scarleteen.com/glossary/term/3338",
            "foreskin" => "http://www.scarleteen.com/glossary/term/3351",
            "fourchette" => "http://www.scarleteen.com/glossary/term/3395",
            "friends with benefits" => "http://www.scarleteen.com/glossary/term/3463",
            "frottage" => "http://www.scarleteen.com/glossary/term/3316",
            "gay" => "http://www.scarleteen.com/glossary/term/3341",
            "gender dysphoria" => "http://www.scarleteen.com/glossary/term/3322",
            "gender expression" => "http://www.scarleteen.com/glossary/term/3406",
            "gender identity" => "http://www.scarleteen.com/glossary/term/3319",
            "gender nonconforming" => "http://www.scarleteen.com/glossary/term/3503",
            "gender" => "http://www.scarleteen.com/glossary/term/3320",
            "gendernormative" => "http://www.scarleteen.com/glossary/term/3321",
            "genderqueer" => "http://www.scarleteen.com/glossary/term/3471",
            "genital sex" => "http://www.scarleteen.com/glossary/term/3403",
            "genitals" => "http://www.scarleteen.com/glossary/term/3329",
            "glans" => "http://www.scarleteen.com/glossary/term/3372",
            "gonads" => "http://www.scarleteen.com/glossary/term/3485",
            "gynecological exam" => "http://www.scarleteen.com/glossary/term/3458",
            "healthcare provider" => "http://www.scarleteen.com/glossary/term/3448",
            "heterosexual" => "http://www.scarleteen.com/glossary/term/3381",
            "homophobia" => "http://www.scarleteen.com/glossary/term/3366",
            "homosexual" => "http://www.scarleteen.com/glossary/term/3382",
            "hymen" => "http://www.scarleteen.com/glossary/term/3461",
            "identity" => "http://www.scarleteen.com/glossary/term/3378",
            "infection" => "http://www.scarleteen.com/glossary/term/3526",
            "insertive partner" => "http://www.scarleteen.com/glossary/term/3454",
            "intercourse" => "http://www.scarleteen.com/glossary/term/3336",
            "intersex" => "http://www.scarleteen.com/glossary/term/3500",
            "introitus" => "http://www.scarleteen.com/glossary/term/3396",
            "kinky" => "http://www.scarleteen.com/glossary/term/3425",
            "kissing" => "http://www.scarleteen.com/glossary/term/3313",
            "labia" => "http://www.scarleteen.com/glossary/term/3362",
            "lesbian" => "http://www.scarleteen.com/glossary/term/3342",
            "libido" => "http://www.scarleteen.com/glossary/term/3502",
            "lubricant" => "http://www.scarleteen.com/glossary/term/3332",
            "making out" => "http://www.scarleteen.com/glossary/term/3314",
            "manual sex" => "http://www.scarleteen.com/glossary/term/3328",
            "masculine" => "http://www.scarleteen.com/glossary/term/3456",
            "masturbation" => "http://www.scarleteen.com/glossary/term/3312",
            "menarche" => "http://www.scarleteen.com/glossary/term/3533",
            "menses" => "http://www.scarleteen.com/glossary/term/3491",
            "menstruation" => "http://www.scarleteen.com/glossary/term/3490",
            "miscarriage" => "http://www.scarleteen.com/glossary/term/3310",
            "molluscum" => "http://www.scarleteen.com/glossary/term/3420",
            "monogamous" => "http://www.scarleteen.com/glossary/term/3422",
            "mons" => "http://www.scarleteen.com/glossary/term/3370",
            "mutual masturbation" => "http://www.scarleteen.com/glossary/term/3327",
            "nervous system" => "http://www.scarleteen.com/glossary/term/3353",
            "non-exclusive" => "http://www.scarleteen.com/glossary/term/3513",
            "oral contraceptives" => "http://www.scarleteen.com/glossary/term/3431",
            "oral contraceptives" => "http://www.scarleteen.com/glossary/term/3440",
            "oral sex" => "http://www.scarleteen.com/glossary/term/3330",
            "orgasm" => "http://www.scarleteen.com/glossary/term/3354",
            "out" => "http://www.scarleteen.com/glossary/term/3532",
            "ovaries" => "http://www.scarleteen.com/glossary/term/3484",
            "ovulation" => "http://www.scarleteen.com/glossary/term/3497",
            "ovum" => "http://www.scarleteen.com/glossary/term/3429",
            "pansexual" => "http://www.scarleteen.com/glossary/term/3476",
            "pap smear" => "http://www.scarleteen.com/glossary/term/3421",
            "partner" => "http://www.scarleteen.com/glossary/term/3385",
            "penis" => "http://www.scarleteen.com/glossary/term/3324",
            "penis-in-vagina intercourse" => "http://www.scarleteen.com/glossary/term/3333",
            "perianal" => "http://www.scarleteen.com/glossary/term/3364",
            "perineum" => "http://www.scarleteen.com/glossary/term/3365",
            "period" => "http://www.scarleteen.com/glossary/term/3435",
            "petting" => "http://www.scarleteen.com/glossary/term/3315",
            "phone sex" => "http://www.scarleteen.com/glossary/term/3451",
            "polyamorous" => "http://www.scarleteen.com/glossary/term/3423",
            "pornography" => "http://www.scarleteen.com/glossary/term/3515",
            "pre-ejaculate" => "http://www.scarleteen.com/glossary/term/3487",
            "pregnancy test" => "http://www.scarleteen.com/glossary/term/3498",
            "pregnancy" => "http://www.scarleteen.com/glossary/term/3390",
            "progesterone" => "http://www.scarleteen.com/glossary/term/3446",
            "prostate gland" => "http://www.scarleteen.com/glossary/term/3369",
            "puberty" => "http://www.scarleteen.com/glossary/term/3486",
            "queer" => "http://www.scarleteen.com/glossary/term/3344",
            "racism" => "http://www.scarleteen.com/glossary/term/3468",
            "rape" => "http://www.scarleteen.com/glossary/term/3339",
            "receptive partner" => "http://www.scarleteen.com/glossary/term/3453",
            "rectum" => "http://www.scarleteen.com/glossary/term/3363",
            "relationship" => "http://www.scarleteen.com/glossary/term/3307",
            "reproductive rights" => "http://www.scarleteen.com/glossary/term/3380",
            "romantic" => "http://www.scarleteen.com/glossary/term/3511",
            "safer sex" => "http://www.scarleteen.com/glossary/term/3424",
            "self-gratification" => "http://www.scarleteen.com/glossary/term/3405",
            "semen" => "http://www.scarleteen.com/glossary/term/3427",
            "sensitivity" => "http://www.scarleteen.com/glossary/term/3361",
            "sex" => "http://www.scarleteen.com/glossary/term/3311",
            "sexism" => "http://www.scarleteen.com/glossary/term/3467",
            "sexual assault" => "http://www.scarleteen.com/glossary/term/3394",
            "sexual fantasy" => "http://www.scarleteen.com/glossary/term/3518",
            "sexual orientation" => "http://www.scarleteen.com/glossary/term/3352",
            "sexual" => "http://www.scarleteen.com/glossary/term/3348",
            "sexually active" => "http://www.scarleteen.com/glossary/term/3439",
            "sexually transmitted infections" => "http://www.scarleteen.com/glossary/term/3384",
            "shaft" => "http://www.scarleteen.com/glossary/term/3374",
            "simultaneous orgasm" => "http://www.scarleteen.com/glossary/term/3509",
            "slut" => "http://www.scarleteen.com/glossary/term/3436",
            "social justice" => "http://www.scarleteen.com/glossary/term/3528",
            "sperm" => "http://www.scarleteen.com/glossary/term/3428",
            "spermicide" => "http://www.scarleteen.com/glossary/term/3444",
            "stereotype" => "http://www.scarleteen.com/glossary/term/3501",
            "stone" => "http://www.scarleteen.com/glossary/term/3433",
            "testes" => "http://www.scarleteen.com/glossary/term/3325",
            "testosterone" => "http://www.scarleteen.com/glossary/term/3445",
            "the implant" => "http://www.scarleteen.com/glossary/term/3479",
            "the patch" => "http://www.scarleteen.com/glossary/term/3443",
            "the pill" => "http://www.scarleteen.com/glossary/term/3430",
            "the rhythm method" => "http://www.scarleteen.com/glossary/term/3482",
            "the ring" => "http://www.scarleteen.com/glossary/term/3442",
            "the shot" => "http://www.scarleteen.com/glossary/term/3478",
            "threesome" => "http://www.scarleteen.com/glossary/term/3514",
            "trans sexual" => "http://www.scarleteen.com/glossary/term/3505",
            "transgender" => "http://www.scarleteen.com/glossary/term/3506",
            "transphobia" => "http://www.scarleteen.com/glossary/term/3368",
            "trauma" => "http://www.scarleteen.com/glossary/term/3388",
            "tribadism" => "http://www.scarleteen.com/glossary/term/3317",
            "tribbing" => "http://www.scarleteen.com/glossary/term/3318",
            "trigger" => "http://www.scarleteen.com/glossary/term/3399",
            "triggering" => "http://www.scarleteen.com/glossary/term/3400",
            "urethra" => "http://www.scarleteen.com/glossary/term/3350",
            "uterus" => "http://www.scarleteen.com/glossary/term/3392",
            "vagina" => "http://www.scarleteen.com/glossary/term/3323",
            "vaginal intercourse" => "http://www.scarleteen.com/glossary/term/3334",
            "vaginal opening" => "http://www.scarleteen.com/glossary/term/3371",
            "vanilla" => "http://www.scarleteen.com/glossary/term/3426",
            "vasocongestion" => "http://www.scarleteen.com/glossary/term/3507",
            "vestibular bulbs" => "http://www.scarleteen.com/glossary/term/3375",
            "vulva" => "http://www.scarleteen.com/glossary/term/3308",
            "withdrawal" => "http://www.scarleteen.com/glossary/term/3480",
            "zygote" => "http://www.scarleteen.com/glossary/term/3493"
        );
    }

    $text = " $text ";
    foreach($sexpositiveterm_sexpositiveterm as $term => $desc) {
        if (is_array($desc)) {
            $regex   = array_keys($desc);
            $search  = $regex[0]; // there should always be just one value here
            $replace = $desc[$search];
            $text = preg_replace("/\b$search\b/", "<a href=\"$replace\" class=\"sspg term\" title=\"Look up '$1'\">$1</a>", $text);
        } else {
            /*    For advanced users, there are several possible regular expressions here....
             *    The safest, "default" one is at the top ...
             *    You (or I) may choose to use one of the others!
             *    Pick whichever you want, and make SURE there is only one that isn't preceded by slashes: //
             */
            // OLD DEFAULT: CONSERVATIVE
            //    $text = preg_replace("|([\s\>])$acronym([\s\<\.,;:\\/\-])|imsU" , "$1<acronym title=\"$description\">$acronym</acronym>$2" , $text);

            // NEW DEFAULT: MORE DARING (case insensitive)
            $text = preg_replace("|([^./?&]\b)$term(\b[^:])|imsU" , "$1<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>$2" , $text);
            $text = preg_replace("|(<[A-Za-z]* [^>]*)<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>([^<]*>)|imsU" , "$1$term$2" , $text);

            // SAME AS ABOVE, but CASE SENSITIVE
            //    $text = preg_replace("|([^./]\b)$acronym(\b[^:])|msU" , "$1<acronym title=\"$description\">$acronym</acronym>$2" , $text);
            //    $text = preg_replace("|(<[A-Za-z]* [^>]*)<acronym title=\"$description\">$acronym</acronym>([^<]*>)|msU" , "$1$acronym$2" , $text);

            // BY REQUEST: if the following preg_replace here is uncommented:
            //             acronyms wrapped in dollar signs will just be unwrapped
            //             So: $AOL$ will become AOL, without the <acronym title="America Online">AOL</acronym>
            $text = preg_replace("|[$]<a href=\"$desc\" class=\"sspg term\" title=\"Look up '$term'\">$term</a>[$]|imsU", "$term", $text);
        }
    }
    return trim( $text );
}

add_filter('the_content', 'sexPositiveGlossaryTerm', 8);
//add_filter('comment_text', 'sexPositiveGlossaryTerm', 8);
?>
