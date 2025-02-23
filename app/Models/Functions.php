<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Session;
use Avatar;
use DB;

class Functions extends Model
{
    //GM 1: Salary //GM 2: Manager //GM 3: Manager +1 //GM 4: Directeur //GM 5: Directeur +1 // GM 6: RH

    use HasFactory;

    public static function IsConnected()
    {
        return Session::get('Id') !== null && Session::get('Email') !== null;
    }

    public static function IsAdministrator()
    {
        return Session::get('Id') !== null && Session::get('Email') !== null && Session::get('WorkJob') === 'Administrator';
    }

    public static function IsDirector()
    {
        return Session::get('Id') !== null && Session::get('Email') !== null && Session::get('WorkJob') === 'Director';
    }

    public static function IsManager()
    {
        return Session::get('Id') !== null && Session::get('Email') !== null && Session::get('WorkJob') === 'Manager';
    }

    public static function getActualCalendar()
    {
        Carbon::setLocale('fr');
        return Carbon::now()->format('d F Y à H:i');
    }

    public static function formaTime($Time)
    {
        Carbon::setLocale('fr');
        return Carbon::parse($Time)->format('d F Y à H:i');
    }

    public static function formaDate($Time)
    {
        Carbon::setLocale('fr');
        return Carbon::parse($Time)->format('d F Y');
    }

    public static function formaCertif($Time)
    {
        Carbon::setLocale('fr');
        return Carbon::parse($Time)->format('Y-m');
    }

    public static function formaYear($Time)
    {
        Carbon::setLocale('fr');
        return Carbon::parse($Time)->format('Y');
    }

    public static function unSyncDate($Time)
    {
        Carbon::setLocale('fr');
        return Carbon::parse($Time)->format('Y-m-d');
    }

    public static function GeneratAvatar($UserId) {
        $User = DB::table('hs_users')->where('Id', $UserId)->first();

        if(!is_null($User)) {
            if(!empty($User->Avatar)) {
                $Avatar = url('resources/storages/avatars') . '/' . $User->Avatar;
            } else {
                $Avatar = Avatar::create($User->Name)->toBase64();
            }

            return $Avatar;
        }
        return null;
    }

    public static function calculateDaysBetween($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $days = $start->diffInDays($end);
        
        return $days > 1 ? $days - 1 : $days;
    }

    public static function getJobColor($WorkJob)
    {
        switch($WorkJob)
        {
            case 'Administrator':
                return 'danger';
            case 'Director':
                return 'success';
            case 'Manager':
                return 'info';
            case 'Salary':
                return 'secondary';
        }

        return 'UNK_COLOR';
    }

    public static function getStatusColor($Status)
    {
        switch($Status)
        {
            case 'WAITING':
                return 'info';
            case 'APPROVED':
                return 'olive';
            case 'CANCELLED':
                return 'danger';
        }

        return 'UNK_COLOR';
    }

    public static function getWorkFunction($FunctionId)
    {
        $Query = DB::table('hs_workfunctions')->where('Id', $FunctionId)->first();

        if(!is_null($Query)) {
            return $Query->JobFunction;
        }

        return 'UNK_TEXT';
    }

    public static function getWorkDFunction($FunctionId)
    {
        $Query = DB::table('hs_workfunctions')->where('Id', $FunctionId)->first();

        if(!is_null($Query)) {
            return $Query->Department;
        }

        return 'UNK_TEXT';
    }

    public static function getEUVersion($String)
    {
        switch($String)
        {
            //OTHERS
            case 'Administrator':
                return 'Administrateur';
            case 'Director':
                return 'Directeur';
            case 'Manager':
                return 'Résponsable';
            case 'Salary':
                return 'Salarié(e)';
            case 'WAITING':
                return 'En Attente';
            case 'APPROVED':
                return 'Approuvé';
            case 'CANCELLED':
                return 'Rejeté';

            //DIRECTORS
            case 'DG':
                return 'Directeur Générale';
            case 'DTM':
                return 'Directeur Technique et Maintenance';
            case 'DCG':
                return 'Directeur Controle de Gestion';
            case 'DATD':
                return 'Directeur Achats thés et Développement';
            case 'DO':
                return 'Directrice des Opérations';


            //MANAGERS
            case 'RIE':
                return 'Responsable Import-Export';
            case 'RRD':
                return 'Responsable R&D';
            case 'RAC':
                return 'Responsable Amélioration Continue';
            case 'CE':
                return 'Chef Équipe';
            case 'RA':
                return 'Responsable Approvisionnement';
            case 'RP':
                return 'Responsable Production';
            case 'CC':
                return 'Chef Comptable';
            case 'RT':
                return 'Responsable Trésorerie';
            case 'RATE':
                return 'Responsable Achats Technique et Emballages';
            case 'RSI':
                return 'Responsable SI';
            case 'RAV':
                return 'Responsable Administration des Ventes';
            case 'RRH':
                return 'Responsable RH';
            case 'RQHSE':
                return 'Responsable QHSE';
            case 'RPP':
                return 'Responsable Projets Packaging';
            case 'RPL':
                return 'Responsable Planification et Logistique';
            case 'CTS':
                return 'Chef Technicien Supérieur';
            case 'RAT':
                return 'Responsable Achats thés';
            case 'RADV':
                return 'Responsable ADV';
            case 'RA':
                return 'Responsable Approvisionnement';
            case 'CCD':
                return 'Chef Chargé Dépôt';
            case 'CGS':
                return 'Chef Gestionnaires de Stock';
            case 'RPMG':
                return 'Responsable Projet et Moyen Généraux';
            case 'RSF':
                return 'Responsable Sommelier Formation';
            case 'CPM':
                return 'Chef Produit Marketing';


            //SALARIES
            case 'S#CPRD':
                return 'Chargé Process et R&D';
            case 'S#CQL':
                return 'Chargé Qualité et Laboratoire';
            case 'S#CRH':
                return 'Chargé(e) RH';
            case 'S#CARHP':
                return 'Chargée Administrative RH et Paie';
            case 'S#AMS':
                return 'Assistante Médico-Social';
            case 'S#ASF':
                return 'Acheteuse Sénior';
            case 'S#MG':
                return 'Magasinier(e)';
            case 'S#CCTF':
                return 'Comptable Caisse et TVA Fournisseur';
            case 'S#ARSI':
                return 'Administrateur Réseaux et Système Information';
            case 'S#CIE':
                return 'Chargé(e) d\'Import & Export';
            case 'S#CDRH':
                return 'Chargée Développement RH';
            case 'S#CAV':
                return 'Chargée d\'Administration des Ventes';
            case 'S#CGPAO':
                return 'Chargée GPAO';
            case 'S#CG':
                return 'Contrôleur de Gestion';
            case 'S#AS':
                return 'Acheteur Senior';
            case 'S#CM':
                return 'Chargé de Methode';
            case 'S#CABO':
                return 'Chargée Accueil et Bureau Ordre';
            case 'S#CS':
                return 'Comptable Senior';
            case 'S#TLF':
                return 'Technicienne de Laboratoire';
            case 'S#CPT':
                return 'Comptable';
            case 'S#CCQ':
                return 'Chargée Contrôle Qualité';
            case 'S#TL':
                return 'Technicien de Laboratoire';
            case 'S#GS':
                return 'Gestionnaire de Stocks';
            case 'S#GM':
                return 'Chargée de Missions';
            case 'S#SHSE':
                return 'Superviseur HSE';
            case 'S#EC':
                return 'Equipe de Contrôle';
            case 'S#CAQE':
                return 'Chargée Assurance Qualité et Export';
            case 'S#CMG':
                return 'Chargé Moyens Généraux';
            case 'S#INFO':
                return 'Informaticien';
            case 'S#COURS':
                return 'Coursiers';
            case 'S#OP':
                return 'Opérateurs de Production';
            case 'S#CMACHINE':
                return 'Conducteurs de Machine';
            case 'S#TS':
                return 'Technicien Suprérieur';
            case 'S#TECHN':
                return 'Technicien ';
            case 'S#CR':
                return 'Chargé Règlement';
            case 'S#CRD':
                return 'Chargée R&D';
            case 'S#CD':
                return 'Chargée Dépôt';
            case 'S#CARIS':
                return 'Caristes';
            case 'S#MANUTE':
                return 'Manutentionnaires';
        }

        return 'UNK_TEXT';
    }



    public static function Clean( $title, $fallback_title = '', $context = 'save' ) {
        $raw_title = $title;
        if ( 'save' === $context ) {
            $title = Functions::custom_remove_accents( $title );
        }

        $title = Functions::custom_sanitize_title_with_dashes( $title );

        if ( '' === $title || false === $title ) {
            $title = $fallback_title;
        }

        return $title;
    }

    public static function custom_sanitize_title_with_dashes( $title, $raw_title = '', $context = 'display' ) {
        $title = strip_tags( $title );

        $title = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title );

        $title = str_replace( '%', '', $title );

        $title = preg_replace( '|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title );

        if ( Functions::custom_seems_utf8( $title ) ) {
            if ( function_exists( 'mb_strtolower' ) ) {
                $title = mb_strtolower( $title, 'UTF-8' );
            }
            $title = Functions::custom_utf8_uri_encode( $title, 200 );
        }

        $title = strtolower( $title );

        if ( 'save' === $context ) {

            $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );

            $title = str_replace( array( '&nbsp;', '&#160;', '&ndash;', '&#8211;', '&mdash;', '&#8212;' ), '-', $title );

            $title = str_replace( '/', '-', $title );

            $title = str_replace(
                array(
                    '%c2%ad',
                    '%c2%a1',
                    '%c2%bf',
                    '%c2%ab',
                    '%c2%bb',
                    '%e2%80%b9',
                    '%e2%80%ba',
                    '%e2%80%98',
                    '%e2%80%99',
                    '%e2%80%9c',
                    '%e2%80%9d',
                    '%e2%80%9a',
                    '%e2%80%9b',
                    '%e2%80%9e',
                    '%e2%80%9f',
                    '%e2%80%a2',
                    '%c2%a9',
                    '%c2%ae',
                    '%c2%b0',
                    '%e2%80%a6',
                    '%e2%84%a2',
                    '%c2%b4',
                    '%cb%8a',
                    '%cc%81',
                    '%cd%81',
                    '%cc%80',
                    '%cc%84',
                    '%cc%8c',
                ),
                '',
                $title
            );

            $title = str_replace( '%c3%97', 'x', $title );
        }

        $title = preg_replace( '/&.+?;/', '', $title );
        $title = str_replace( '.', '-', $title );

        $title = preg_replace( '/[^%a-z0-9 _-]/', '', $title );
        $title = preg_replace( '/\s+/', '-', $title );
        $title = preg_replace( '|-+|', '-', $title );
        $title = trim( $title, '-' );

        return $title;
    }

    public static function custom_remove_accents( $string ) {
        if ( ! preg_match( '/[\x80-\xff]/', $string ) ) {
            return $string;
        }

        if (Functions::custom_seems_utf8( $string ) ) {
            $chars = array(
                'ª' => 'a',
                'º' => 'o',
                'À' => 'A',
                'Á' => 'A',
                'Â' => 'A',
                'Ã' => 'A',
                'Ä' => 'A',
                'Å' => 'A',
                'Æ' => 'AE',
                'Ç' => 'C',
                'È' => 'E',
                'É' => 'E',
                'Ê' => 'E',
                'Ë' => 'E',
                'Ì' => 'I',
                'Í' => 'I',
                'Î' => 'I',
                'Ï' => 'I',
                'Ð' => 'D',
                'Ñ' => 'N',
                'Ò' => 'O',
                'Ó' => 'O',
                'Ô' => 'O',
                'Õ' => 'O',
                'Ö' => 'O',
                'Ù' => 'U',
                'Ú' => 'U',
                'Û' => 'U',
                'Ü' => 'U',
                'Ý' => 'Y',
                'Þ' => 'TH',
                'ß' => 's',
                'à' => 'a',
                'á' => 'a',
                'â' => 'a',
                'ã' => 'a',
                'ä' => 'a',
                'å' => 'a',
                'æ' => 'ae',
                'ç' => 'c',
                'è' => 'e',
                'é' => 'e',
                'ê' => 'e',
                'ë' => 'e',
                'ì' => 'i',
                'í' => 'i',
                'î' => 'i',
                'ï' => 'i',
                'ð' => 'd',
                'ñ' => 'n',
                'ò' => 'o',
                'ó' => 'o',
                'ô' => 'o',
                'õ' => 'o',
                'ö' => 'o',
                'ø' => 'o',
                'ù' => 'u',
                'ú' => 'u',
                'û' => 'u',
                'ü' => 'u',
                'ý' => 'y',
                'þ' => 'th',
                'ÿ' => 'y',
                'Ø' => 'O',

                'Ā' => 'A',
                'ā' => 'a',
                'Ă' => 'A',
                'ă' => 'a',
                'Ą' => 'A',
                'ą' => 'a',
                'Ć' => 'C',
                'ć' => 'c',
                'Ĉ' => 'C',
                'ĉ' => 'c',
                'Ċ' => 'C',
                'ċ' => 'c',
                'Č' => 'C',
                'č' => 'c',
                'Ď' => 'D',
                'ď' => 'd',
                'Đ' => 'D',
                'đ' => 'd',
                'Ē' => 'E',
                'ē' => 'e',
                'Ĕ' => 'E',
                'ĕ' => 'e',
                'Ė' => 'E',
                'ė' => 'e',
                'Ę' => 'E',
                'ę' => 'e',
                'Ě' => 'E',
                'ě' => 'e',
                'Ĝ' => 'G',
                'ĝ' => 'g',
                'Ğ' => 'G',
                'ğ' => 'g',
                'Ġ' => 'G',
                'ġ' => 'g',
                'Ģ' => 'G',
                'ģ' => 'g',
                'Ĥ' => 'H',
                'ĥ' => 'h',
                'Ħ' => 'H',
                'ħ' => 'h',
                'Ĩ' => 'I',
                'ĩ' => 'i',
                'Ī' => 'I',
                'ī' => 'i',
                'Ĭ' => 'I',
                'ĭ' => 'i',
                'Į' => 'I',
                'į' => 'i',
                'İ' => 'I',
                'ı' => 'i',
                'Ĳ' => 'IJ',
                'ĳ' => 'ij',
                'Ĵ' => 'J',
                'ĵ' => 'j',
                'Ķ' => 'K',
                'ķ' => 'k',
                'ĸ' => 'k',
                'Ĺ' => 'L',
                'ĺ' => 'l',
                'Ļ' => 'L',
                'ļ' => 'l',
                'Ľ' => 'L',
                'ľ' => 'l',
                'Ŀ' => 'L',
                'ŀ' => 'l',
                'Ł' => 'L',
                'ł' => 'l',
                'Ń' => 'N',
                'ń' => 'n',
                'Ņ' => 'N',
                'ņ' => 'n',
                'Ň' => 'N',
                'ň' => 'n',
                'ŉ' => 'n',
                'Ŋ' => 'N',
                'ŋ' => 'n',
                'Ō' => 'O',
                'ō' => 'o',
                'Ŏ' => 'O',
                'ŏ' => 'o',
                'Ő' => 'O',
                'ő' => 'o',
                'Œ' => 'OE',
                'œ' => 'oe',
                'Ŕ' => 'R',
                'ŕ' => 'r',
                'Ŗ' => 'R',
                'ŗ' => 'r',
                'Ř' => 'R',
                'ř' => 'r',
                'Ś' => 'S',
                'ś' => 's',
                'Ŝ' => 'S',
                'ŝ' => 's',
                'Ş' => 'S',
                'ş' => 's',
                'Š' => 'S',
                'š' => 's',
                'Ţ' => 'T',
                'ţ' => 't',
                'Ť' => 'T',
                'ť' => 't',
                'Ŧ' => 'T',
                'ŧ' => 't',
                'Ũ' => 'U',
                'ũ' => 'u',
                'Ū' => 'U',
                'ū' => 'u',
                'Ŭ' => 'U',
                'ŭ' => 'u',
                'Ů' => 'U',
                'ů' => 'u',
                'Ű' => 'U',
                'ű' => 'u',
                'Ų' => 'U',
                'ų' => 'u',
                'Ŵ' => 'W',
                'ŵ' => 'w',
                'Ŷ' => 'Y',
                'ŷ' => 'y',
                'Ÿ' => 'Y',
                'Ź' => 'Z',
                'ź' => 'z',
                'Ż' => 'Z',
                'ż' => 'z',
                'Ž' => 'Z',
                'ž' => 'z',
                'ſ' => 's',

                'Ș' => 'S',
                'ș' => 's',
                'Ț' => 'T',
                'ț' => 't',

                '€' => 'E',

                '£' => '',

                'Ơ' => 'O',
                'ơ' => 'o',
                'Ư' => 'U',
                'ư' => 'u',

                'Ầ' => 'A',
                'ầ' => 'a',
                'Ằ' => 'A',
                'ằ' => 'a',
                'Ề' => 'E',
                'ề' => 'e',
                'Ồ' => 'O',
                'ồ' => 'o',
                'Ờ' => 'O',
                'ờ' => 'o',
                'Ừ' => 'U',
                'ừ' => 'u',
                'Ỳ' => 'Y',
                'ỳ' => 'y',

                'Ả' => 'A',
                'ả' => 'a',
                'Ẩ' => 'A',
                'ẩ' => 'a',
                'Ẳ' => 'A',
                'ẳ' => 'a',
                'Ẻ' => 'E',
                'ẻ' => 'e',
                'Ể' => 'E',
                'ể' => 'e',
                'Ỉ' => 'I',
                'ỉ' => 'i',
                'Ỏ' => 'O',
                'ỏ' => 'o',
                'Ổ' => 'O',
                'ổ' => 'o',
                'Ở' => 'O',
                'ở' => 'o',
                'Ủ' => 'U',
                'ủ' => 'u',
                'Ử' => 'U',
                'ử' => 'u',
                'Ỷ' => 'Y',
                'ỷ' => 'y',

                'Ẫ' => 'A',
                'ẫ' => 'a',
                'Ẵ' => 'A',
                'ẵ' => 'a',
                'Ẽ' => 'E',
                'ẽ' => 'e',
                'Ễ' => 'E',
                'ễ' => 'e',
                'Ỗ' => 'O',
                'ỗ' => 'o',
                'Ỡ' => 'O',
                'ỡ' => 'o',
                'Ữ' => 'U',
                'ữ' => 'u',
                'Ỹ' => 'Y',
                'ỹ' => 'y',

                'Ấ' => 'A',
                'ấ' => 'a',
                'Ắ' => 'A',
                'ắ' => 'a',
                'Ế' => 'E',
                'ế' => 'e',
                'Ố' => 'O',
                'ố' => 'o',
                'Ớ' => 'O',
                'ớ' => 'o',
                'Ứ' => 'U',
                'ứ' => 'u',

                'Ạ' => 'A',
                'ạ' => 'a',
                'Ậ' => 'A',
                'ậ' => 'a',
                'Ặ' => 'A',
                'ặ' => 'a',
                'Ẹ' => 'E',
                'ẹ' => 'e',
                'Ệ' => 'E',
                'ệ' => 'e',
                'Ị' => 'I',
                'ị' => 'i',
                'Ọ' => 'O',
                'ọ' => 'o',
                'Ộ' => 'O',
                'ộ' => 'o',
                'Ợ' => 'O',
                'ợ' => 'o',
                'Ụ' => 'U',
                'ụ' => 'u',
                'Ự' => 'U',
                'ự' => 'u',
                'Ỵ' => 'Y',
                'ỵ' => 'y',

                'ɑ' => 'a',

                'Ǖ' => 'U',
                'ǖ' => 'u',

                'Ǘ' => 'U',
                'ǘ' => 'u',

                'Ǎ' => 'A',
                'ǎ' => 'a',
                'Ǐ' => 'I',
                'ǐ' => 'i',
                'Ǒ' => 'O',
                'ǒ' => 'o',
                'Ǔ' => 'U',
                'ǔ' => 'u',
                'Ǚ' => 'U',
                'ǚ' => 'u',

                'Ǜ' => 'U',
                'ǜ' => 'u',
            );

            $string = strtr( $string, $chars );
        } else {
            $chars = array();

            $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
                . "\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
                . "\xc3\xc4\xc5\xc7\xc8\xc9\xca"
                . "\xcb\xcc\xcd\xce\xcf\xd1\xd2"
                . "\xd3\xd4\xd5\xd6\xd8\xd9\xda"
                . "\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
                . "\xe4\xe5\xe7\xe8\xe9\xea\xeb"
                . "\xec\xed\xee\xef\xf1\xf2\xf3"
                . "\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
                . "\xfc\xfd\xff";

            $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

            $string              = strtr( $string, $chars['in'], $chars['out'] );
            $double_chars        = array();
            $double_chars['in']  = array( "\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe" );
            $double_chars['out'] = array( 'OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th' );
            $string              = str_replace( $double_chars['in'], $double_chars['out'], $string );
        }

        return $string;
    }

    public static function custom_seems_utf8( $str ) {
        Functions::custom_mbstring_binary_safe_encoding();
        $length = strlen( $str );
        Functions::custom_reset_mbstring_encoding();
        for ( $i = 0; $i < $length; $i++ ) {
            $c = ord( $str[ $i ] );
            if ( $c < 0x80 ) {
                $n = 0; 
            } elseif ( ( $c & 0xE0 ) == 0xC0 ) {
                $n = 1; 
            } elseif ( ( $c & 0xF0 ) == 0xE0 ) {
                $n = 2; 
            } elseif ( ( $c & 0xF8 ) == 0xF0 ) {
                $n = 3; 
            } elseif ( ( $c & 0xFC ) == 0xF8 ) {
                $n = 4; 
            } elseif ( ( $c & 0xFE ) == 0xFC ) {
                $n = 5; 
            } else {
                return false; 
            }
            for ( $j = 0; $j < $n; $j++ ) { 
                if ( ( ++$i == $length ) || ( ( ord( $str[ $i ] ) & 0xC0 ) != 0x80 ) ) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function custom_mbstring_binary_safe_encoding( $reset = false ) {
        static $encodings  = array();
        static $overloaded = null;

        if ( is_null( $overloaded ) ) {
            $overloaded = function_exists( 'mb_internal_encoding' ); 
        }

        if ( false === $overloaded ) {
            return;
        }

        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding( 'ISO-8859-1' );
        }

        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }

    public static function custom_reset_mbstring_encoding() {
        Functions::custom_mbstring_binary_safe_encoding( true );
    }

    public static function custom_utf8_uri_encode( $utf8_string, $length = 0 ) {
        $unicode        = '';
        $values         = array();
        $num_octets     = 1;
        $unicode_length = 0;

        Functions::custom_mbstring_binary_safe_encoding();
        $string_length = strlen( $utf8_string );
        Functions::custom_reset_mbstring_encoding();

        for ( $i = 0; $i < $string_length; $i++ ) {

            $value = ord( $utf8_string[ $i ] );

            if ( $value < 128 ) {
                if ( $length && ( $unicode_length >= $length ) ) {
                    break;
                }
                $unicode .= chr( $value );
                $unicode_length++;
            } else {
                if ( count( $values ) == 0 ) {
                    if ( $value < 224 ) {
                        $num_octets = 2;
                    } elseif ( $value < 240 ) {
                        $num_octets = 3;
                    } else {
                        $num_octets = 4;
                    }
                }

                $values[] = $value;

                if ( $length && ( $unicode_length + ( $num_octets * 3 ) ) > $length ) {
                    break;
                }
                if ( count( $values ) == $num_octets ) {
                    for ( $j = 0; $j < $num_octets; $j++ ) {
                        $unicode .= '%' . dechex( $values[ $j ] );
                    }

                    $unicode_length += $num_octets * 3;

                    $values     = array();
                    $num_octets = 1;
                }
            }
        }

        return $unicode;
    }
}
