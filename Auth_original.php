<?php

namespace App\Http\Controllers;

use App\Models\Functions;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Mail\RequestClient;
use App\Mail\RequestClientCertif;

class Auth extends Controller
{
    public function handleUserSignIn(Request $request)
    {
        $isValidRequest = $request->validate(array("UserEmail" => "required", "UserPassword" => "required"));
        if ($isValidRequest) {
            $user = DB::table("hs_users")->where("Email", $request->UserEmail)->first();
            if (!is_null($user)) {
                if ($user->Status == "DELETED") {
                    return response()->json(array("warning" => "Accès refusé. Ce compte a été désactivé."));
                } else {
                    if (password_verify($request->UserPassword, $user->Password)) {
                        $now = Carbon::now();
                        $lastBalanceUpdate = Carbon::parse($user->TimeOfBalance);
                        $monthsPassed = $lastBalanceUpdate->diffInMonths($now);
                        if ($monthsPassed >= 1) {
                            $newBalance = $user->Balance + 1.5;
                            DB::table("hs_users")->where("Id", $user->Id)->update(array("Balance" => $newBalance, "TimeOfBalance" => $now->toDateString()));
                            $user = DB::table("hs_users")->where("Id", $user->Id)->first();
                        }
                        Session::put("Id", $user->Id);
                        Session::put("Name", $user->Name);
                        Session::put("Email", $user->Email);
                        Session::put("Balance", $user->Balance);
                        Session::put("WorkJob", $user->WorkJob);
                        Session::put("WorkFunction", $user->WorkFunction);
                        return response()->json(array("success" => "Vous avez réussi à vous connecter."));
                    } else {
                        return response()->json(array("errors" => "Oops ! Mot de passe invalide."));
                    }
                }
            } else {
                return response()->json(array("errors" => "Oops ! Email invalide."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserSignUp(Request $request)
    {
        $IsValidRequest = $request->validate(array("UserName" => "required", "UserEmail" => "required", "UserSerial" => "required", "UserInsurance" => "required", "UserCIN" => "required", "UserPhone" => "required", "UserWorkJob" => "required", "UserWorkFunction" => "required", "UserTimeOfRegister" => "required", "UserPassword" => "required", "User2Password" => "required|same:UserPassword"));
        if ($IsValidRequest) {
            $Email = DB::table("hs_users")->where("Email", $request->UserEmail)->first();
            if (!is_null($Email)) {
                return response()->json(array("errors" => "Oops ! Cette adresse email est déjà utilisée."));
            } else {
                $Now = Carbon::now()->toDateTimeString();
                $Balance = $request->has("UserBalance") ? $request->UserBalance : 0.0;
                $userCreated = DB::table("hs_users")->insert(array("Name" => $request->UserName, "Email" => $request->UserEmail, "Password" => $request->UserPassword, "Serial" => $request->UserSerial, "Insurance" => $request->UserInsurance, "CIN" => $request->UserCIN, "Phone" => $request->UserPhone, "WorkJob" => $request->UserWorkJob, "WorkFunction" => $request->UserWorkFunction, "TimeOfRegister" => $request->UserTimeOfRegister, "Balance" => $Balance));
                if (!is_null($userCreated)) {
                    return response()->json(array("success" => "Félicitations, Votre utilisateur a été créé avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserUpdate(Request $request)
    {
        $IsValidRequest = $request->validate(array("UserId" => "required", "UserName" => "required", "UserEmail" => "required", "UserSerial" => "required", "UserInsurance" => "required", "UserCIN" => "required", "UserPhone" => "required", "UserBalance" => "required", "UserWorkJob" => "required", "UserWorkFunction" => "required", "UserTimeOfRegister" => "required"));
        if ($IsValidRequest) {
            $User = DB::table("hs_users")->where("Id", $request->UserId)->first();
            if (is_null($User)) {
                return response()->json(array("errors" => "Oops ! L'utilisateur est introuvable."));
            } else {
                $Password = $request->has("UserPassword") ? $request->UserPassword : $User->Password;
                $Now = Carbon::now()->toDateTimeString();
                $userUpdated = DB::table("hs_users")->where("Id", $User->Id)->update(array("Name" => $request->UserName, "Email" => $request->UserEmail, "Password" => $Password, "Serial" => $request->UserSerial, "Insurance" => $request->UserInsurance, "CIN" => $request->UserCIN, "Phone" => $request->UserPhone, "Balance" => $request->UserBalance, "WorkJob" => $request->UserWorkJob, "WorkFunction" => $request->UserWorkFunction, "TimeOfRegister" => $request->UserTimeOfRegister));
                if (!is_null($userUpdated)) {
                    return response()->json(array("success" => "Félicitations, Votre utilisateur a été modifié avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserAvatarUpdate(Request $request)
    {
        $IsValidRequest = $request->validate(array("userTarget" => "required"));
        if ($IsValidRequest) {
            $UserUIKey = $request->userTarget;
            $User = DB::table("hs_users")->where("Id", $UserUIKey)->first();
            if (!is_null($User)) {
                $PathUser = resource_path("storage/avatars");
                if ($request->has("userAvatarUpdated")) {
                    $Image = $request->file("userAvatarUpdated");
                    $AvatarName = time() . "." . $Image->getClientOriginalExtension();
                    $FullPath = $PathUser . "/" . $AvatarName;
                    $Image->save($FullPath);
                    chmod($FullPath, 493);
                    File::delete($PathUser . "/" . $User->Avatar);
                } else {
                    $AvatarName = '';
                    if (File::exists($PathUser . "/" . $User->Avatar)) {
                        File::delete($PathUser . "/" . $User->Avatar);
                    }
                }
                $Update = DB::table("hs_users")->where("Id", $UserUIKey)->update(array("Avatar" => $AvatarName));
                if ($Update) {
                    return response()->json(array("success" => "La modification du profil a été effectuée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserDelete(Request $request)
    {
        $IsValidRequest = $request->validate(array("UserId" => "required"));
        if ($IsValidRequest) {
            $User = DB::table("hs_users")->where("Id", $request->UserId)->first();
            if (is_null($User)) {
                return response()->json(array("errors" => "Oops ! L'utilisateur est introuvable."));
            } else {
                $userDeleted = DB::table("hs_users")->where("Id", $User->Id)->update(array("Status" => "DELETED"));
                if (!is_null($userDeleted)) {
                    return response()->json(array("success" => "Félicitations, Votre utilisateur a été supprimé avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserRestore(Request $request)
    {
        $IsValidRequest = $request->validate(array("UserId" => "required"));
        if ($IsValidRequest) {
            $User = DB::table("hs_users")->where("Id", $request->UserId)->first();
            if (is_null($User)) {
                return response()->json(array("errors" => "Oops ! L'utilisateur est introuvable."));
            } else {
                $userDeleted = DB::table("hs_users")->where("Id", $User->Id)->update(array("Status" => "ACTIF"));
                if (!is_null($userDeleted)) {
                    return response()->json(array("success" => "Félicitations, Votre utilisateur a été restauré avec succès.", "redirect" => "/manager/users/dropped"));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUserSignOut(Request $request)
    {
        Session::flush();
        return response()->json(array("success" => "Vous êtes déconnecté(e) avec succès."));
    }

    public function handleRequestUpdate(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestId" => "required", "RequestStatus" => "required"));
        if ($IsValidRequest) {
            $userRequest = DB::table("hs_aways")->where("Id", $request->RequestId)->first();
            if (is_null($userRequest)) {
                return response()->json(array("errors" => "Oops ! La demande est introuvable."));
            } else {
                $Prefix = Session::get("Prefix", "");
                $Now = Carbon::now()->toDateTimeString();
                $userRequestUpdate = DB::table("hs_aways")->where("Id", $userRequest->Id)->update(array("Status" => $request->RequestStatus, "SeniorId" => Session::get("WorkFunction"), "SeniorPrefix" => $Prefix, "TimeOfSenior" => $Now));
                if ($request->RequestStatus == "APPROVED") {
                    $UserTarget = DB::table("hs_users")->where("Id", $userRequest->UserId)->first();
                    $Balance = $UserTarget->Balance - $userRequest->Nbrs;
                    $Query = DB::table("hs_users")->where("Id", $UserTarget->Id)->update(array("Balance" => $Balance));
                }
                if (!is_null($userRequestUpdate)) {
                    $details = new \stdClass();
                    $details->Name = config("app.name");
                    $details->Title = "Nous avons été traité votre demande.";
                    $details->ClientName = Session::get("Name");
                    $details->TypeVacancy = $request->RequestType;
                    $details->NumDays = number_format($userRequest->Nbrs, 1);
                    $details->TimeOf = Functions::formaTime($userRequest->TimeOf);
                    if ($request->RequestType == "ABSENCE") {
                        $details->TypeName = "Nous avons traité votre demande d'absence.";
                    }
                    $Query = Mail::to("MILOUD.GHIBANE@mathe.ma")->queue(new RequestClient($details));
                    return response()->json(array("success" => "Félicitations, Demande a été modifiée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestCreateV(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestStartDate" => "required", "RequestEndDate" => "required", "RequestType" => "required", "RequestCategory" => "required", "RequestIsHalf" => "required"));
        if ($IsValidRequest) {
            $StartDate = Carbon::parse($request->RequestStartDate)->format("y-m-d");
            $EndDate = Carbon::parse($request->RequestEndDate)->format("y-m-d");
            $Now = Carbon::now()->toDateTimeString();
            $Senior = DB::table("hs_workfunctions")->where("Id", Session::get("WorkFunction"))->first();
            $Prefix = Session::get("Prefix", "");
            $NumDays = $request->RequestIsHalf == 1 ? 0.5 : Functions::calculateDaysBetween($StartDate, $EndDate);
            if ($request->RequestIsHalf == 1) {
                $NumDays = 0.5;
            }
            $userRequestUpdate = DB::table("hs_aways")->insert(array("UserId" => Session::get("Id"), "UserPrefix" => $Prefix, "StartDate" => $StartDate, "EndDate" => $EndDate, "Status" => "WAITING", "TimeOf" => $Now, "SeniorId" => $Senior->Validator, "Type" => $request->RequestType, "Category" => $request->RequestCategory, "Nbrs" => $NumDays, "IsHalf" => $request->RequestIsHalf));
            if (!is_null($userRequestUpdate)) {
                $details = new \stdClass();
                $details->Name = config("app.name");
                $details->Title = "Nous avons reçu votre demande.";
                $details->ClientName = Session::get("Name");
                $details->TypeVacancy = $request->RequestType;
                $details->NumDays = number_format($NumDays, 1);
                $details->TimeOf = Functions::formaTime($Now);
                if ($request->RequestType == "ABSENCE") {
                    $details->TypeName = "Nous avons enregistré votre demande d'absence.";
                }
                $Query = Mail::to("MILOUD.GHIBANE@mathe.ma")->queue(new RequestClient($details));
                return response()->json(array("success" => "Félicitations, Demande a été créée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestUpdateV(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestId" => "required", "RequestStartDate" => "required", "RequestEndDate" => "required", "RequestType" => "required", "RequestCategory" => "required", "RequestIsHalf" => "required"));
        if ($IsValidRequest) {
            $StartDate = Carbon::parse($request->RequestStartDate)->format("y-m-d");
            $EndDate = Carbon::parse($request->RequestEndDate)->format("y-m-d");
            $Now = Carbon::now()->toDateTimeString();
            $userRequest = DB::table("hs_aways")->where("Id", $request->RequestId)->first();
            $User = DB::table("hs_users")->where("Id", $userRequest->UserId)->first();
            $Senior = DB::table("hs_workfunctions")->where("Id", $User->Id)->first();
            $Prefix = Session::get("Prefix", "");
            $NumDays = $request->RequestIsHalf === 1 ? 0.5 : Functions::calculateDaysBetween($StartDate, $EndDate);
            $userRequestUpdate = DB::table("hs_aways")->where("Id", $request->RequestId)->update(array("UserPrefix" => $Prefix, "StartDate" => $StartDate, "EndDate" => $EndDate, "Type" => $request->RequestType, "Nbrs" => $NumDays, "IsHalf" => $request->RequestIsHalf));
            if ($userRequestUpdate && $userRequest->UserId !== Session::get("Id")) {
                $userRequestUpdate = DB::table("hs_aways")->where("Id", $request->RequestId)->update(array("EditorId" => Session::get("WorkFunction"), "TimeOfEditor" => $Now));
            }
            if ($userRequestUpdate) {
                return response()->json(array("success" => "Félicitations, Demande a été modifiée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestCreateA(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestDate" => "required", "RequestType" => "required", "RequestCategory" => "required", "RequestLocation" => "required", "RequestLeaveHours" => "required", "RequestEnterHours" => "required"));
        if ($IsValidRequest) {
            $StartDate = Carbon::parse($request->RequestDate)->format("y-m-d");
            $Now = Carbon::now()->toDateTimeString();
            $Senior = DB::table("hs_workfunctions")->where("Id", Session::get("WorkFunction"))->first();
            $Prefix = Session::get("Prefix", "");
            $userRequestUpdate = DB::table("hs_aways")->insert(array("UserId" => Session::get("Id"), "UserPrefix" => $Prefix, "StartDate" => $StartDate, "EndDate" => $StartDate, "Status" => "WAITING", "TimeOf" => $Now, "SeniorId" => $Senior->Validator, "Type" => $request->RequestType, "Category" => $request->RequestCategory, "Location" => $request->RequestLocation, "Nbrs" => 0, "LeaveHours" => $request->RequestLeaveHours, "EnterHours" => $request->RequestEnterHours));
            if (!is_null($userRequestUpdate)) {
                $details = new \stdClass();
                $details->Name = config("app.name");
                $details->Title = "Demande reçu.";
                $details->ClientName = Session::get("Name");
                $details->TypeVacancy = $request->RequestType;
                $details->NumDays = number_format(0, 1);
                $details->TimeOf = Functions::formaTime($Now);
                $details->EndDate = Functions::formaDate($StartDate);
                $details->TypeName = $request->RequestCategory;
                $Query = Mail::to("MILOUD.GHIBANE@mathe.ma")->queue(new RequestClient($details));
                return response()->json(array("success" => "Félicitations, Demande a été créée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestUpdateA(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestId" => "required", "RequestDate" => "required", "RequestType" => "required", "RequestCategory" => "required", "RequestLocation" => "required", "RequestLeaveHours" => "required", "RequestEnterHours" => "required"));
        if ($IsValidRequest) {
            $StartDate = Carbon::parse($request->RequestDate)->format("y-m-d");
            $Now = Carbon::now()->toDateTimeString();
            $userRequest = DB::table("hs_aways")->where("Id", $request->RequestId)->first();
            $User = DB::table("hs_users")->where("Id", $userRequest->UserId)->first();
            $Senior = DB::table("hs_workfunctions")->where("Id", $User->Id)->first();
            $Prefix = Session::get("Prefix", "");
            $userRequestUpdate = DB::table("hs_aways")->where("Id", $request->RequestId)->update(array("UserPrefix" => $Prefix, "StartDate" => $StartDate, "LeaveHours" => $request->RequestLeaveHours, "EnterHours" => $request->RequestEnterHours, "Type" => $request->RequestType, "Location" => $request->RequestLocation));
            if ($userRequestUpdate && $userRequest->UserId !== Session::get("Id")) {
                $userRequestUpdate = DB::table("hs_aways")->where("Id", $request->RequestId)->update(array("EditorId" => Session::get("WorkFunction"), "TimeOfEditor" => $Now));
            }
            if ($userRequestUpdate) {
                return response()->json(array("success" => "Félicitations, Demande a été modifiée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestCreateC(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestType" => "required"));
        if ($IsValidRequest) {
            $Period = $request->has("RequestPeriod") ? $request->RequestPeriod : null;
            $Now = Carbon::now()->toDateTimeString();
            $Prefix = Session::get("Prefix", "");
            $userRequestCreate = DB::table("hs_certificates")->insert(array("UserId" => Session::get("Id"), "UserPrefix" => $Prefix, "Status" => "WAITING", "Type" => $request->RequestType, "PeriodOf" => $Period, "TimeOf" => $Now));
            if (!is_null($userRequestCreate)) {
                $details = new \stdClass();
                $details->Name = config("app.name");
                $details->Title = "Nous avons reçu votre demande.";
                $details->ClientName = Session::get("Name");
                $details->TypeName = "Nous avons enregistré votre demande d'attestation.";
                $details->DescName = "Nous étudierons votre demande et nous vous répondrons vers vous prochainement. Merci de votre compréhension.";
                $Query = Mail::to("MILOUD.GHIBANE@mathe.ma")->cc("MILOUD.CHIBANE@mathe.ma")->queue(new RequestClientCertif($details));
                return response()->json(array("success" => "Félicitations, Demande a été créée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleRequestUpdateC(Request $request)
    {
        $IsValidRequest = $request->validate(array("RequestId" => "required"));
        if ($IsValidRequest) {
            $RequestTarget = DB::table("hs_certificates")->where("Id", $request->RequestId)->first();
            if (!is_null($RequestTarget)) {
                $UserTarget = DB::table("hs_users")->where("Id", $RequestTarget->UserId)->first();
                $userRequestCreateC = DB::table("hs_certificates")->where("Id", $request->RequestId)->update(array("Status" => "APPROVED"));
                if (!is_null($userRequestCreateC)) {
                    $details = new \stdClass();
                    $details->Name = config("app.name");
                    $details->TypeName = "Nous avons traité votre demande d'attestation.";
                    $details->DescName = "Veuillez récupérer votre attestation.";
                    $Query = Mail::to("MILOUD.GHIBANE@mathe.ma")->queue(new RequestClientCertif($details));
                    return response()->json(array("success" => "Félicitations, Demande a été modifiée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleHolidaysUpdate(Request $request)
    {
        $messages = array("excelHolidays.required" => "Le fichier est requis.", "excelHolidays.file" => "Le fichier doit être un fichier.", "excelHolidays.mimes" => "Le fichier doit être de type xls,xlsx.");
        $IsValidRequest = $request->validate(array("excelHolidays" => "required|file|mimes:xls,xlsx"), $messages);
        if ($IsValidRequest) {
            $DropRows = DB::table("hs_rules")->where("Type", "ADVANCED")->delete();
            $file = $request->file("excelHolidays");
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $Query = false;
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $cellValues = array();
                foreach ($cellIterator as $cell) {
                    $cellValues[] = $cell->getValue();
                }
                if (count($cellValues) == 2) {
                    $queryStringMotif = $cellValues[0];
                    $queryStringValue = $cellValues[1];
                    $Query = DB::table("hs_rules")->insert(array("Label" => $queryStringMotif, "Duration" => $queryStringValue, "Type" => "ADVANCED"));
                }
            }
            if ($Query) {
                return response()->json(array("success" => "Félicitations, Les règles ont été mises à jour avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleFunctionCreate(Request $request)
    {
        $IsValidRequest = $request->validate(array("FunctionLabel" => "required", "FunctionWorkJob" => "required", "FunctionDepartment" => "required", "FunctionValidator" => "required", "FunctionSuperAdmin" => "required"));
        if ($IsValidRequest) {
            $Validator = $request->has("FunctionValidator");
            $userFunctionCreate = DB::table("hs_workfunctions")->insert(array("JobFunction" => $request->FunctionLabel, "WorkJob" => $request->FunctionWorkJob, "Department" => $request->FunctionDepartment, "Validator" => $request->FunctionValidator, "Super" => $request->FunctionSuperAdmin));
            if ($userFunctionCreate) {
                return response()->json(array("success" => "Félicitations, Référence a été créée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleFunctionUpdate(Request $request)
    {
        $IsValidRequest = $request->validate(array("FunctionId" => "required", "FunctionLabel" => "required", "FunctionWorkJob" => "required", "FunctionValidator" => "required", "FunctionDepartment" => "required", "FunctionSuperAdmin" => "required"));
        if ($IsValidRequest) {
            $userFunction = DB::table("hs_workfunctions")->where("Id", $request->FunctionId)->first();
            if (is_null($userFunction)) {
                return response()->json(array("errors" => "Oops ! La référence est introuvable."));
            } else {
                $userFunctionUpdate = DB::table("hs_workfunctions")->where("Id", $userFunction->Id)->update(array("JobFunction" => $request->FunctionLabel, "WorkJob" => $request->FunctionWorkJob, "Department" => $request->FunctionDepartment, "Validator" => $request->FunctionValidator, "Super" => $request->FunctionSuperAdmin));
                if ($userFunctionUpdate) {
                    return response()->json(array("success" => "Félicitations, Référence a été modifiée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleFunctionRemove(Request $request)
    {
        $IsValidRequest = $request->validate(array("FunctionId" => "required"));
        if ($IsValidRequest) {
            $userFunction = DB::table("hs_workfunctions")->where("Id", $request->FunctionId)->first();
            if (is_null($userFunction)) {
                return response()->json(array("errors" => "Oops ! La référence est introuvable."));
            } else {
                $userFunctionRemove = DB::table("hs_workfunctions")->where("Id", $userFunction->Id)->delete();
                if ($userFunctionRemove) {
                    return response()->json(array("success" => "Félicitations, Référence a été supprimée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleLinkUsers(Request $request)
    {
        $IsValidRequest = $request->validate(array("SeniorId" => "required", "ListUsers" => "required"));
        if ($IsValidRequest) {
            $Senior = DB::table("hs_users")->where("Id", $request->SeniorId)->first();
            if ($Senior) {
                $Now = Carbon::now()->toDateTimeString();
                $Prefix = Session::get("Prefix", "");
                $ListUsers = explode(",", $request->ListUsers);
                foreach ($ListUsers as $user) {
                    $userId = trim($user);
                    $UserCible = DB::table("hs_users")->where("Id", $userId)->first();
                    if ($UserCible) {
                        $TeamQuery = DB::table("hs_teams")->where(array("UserId" => $UserCible->Id, "SeniorId" => $Senior->Id))->first();
                        if (is_null($TeamQuery)) {
                            $Query = DB::table("hs_teams")->insert(array("UserId" => $user, "SeniorId" => $Senior->Id, "UserName" => $UserCible->Name, "SeniorName" => $Senior->Name, "TimeOf" => $Now));
                        }
                    }
                }
                return response()->json(array("success" => "Félicitations, Association à été effectuée avec succès."));
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }

    public function handleUnlinkUsers(Request $request)
    {
        $IsValidRequest = $request->validate(array("UserId" => "required", "SeniorId" => "required"));
        if ($IsValidRequest) {
            $TeamQuery = DB::table("hs_teams")->where(array("UserId" => $request->UserId, "SeniorId" => $request->SeniorId))->first();
            if ($TeamQuery) {
                $Query = DB::table("hs_teams")->where(array("UserId" => $request->UserId, "SeniorId" => $request->SeniorId))->delete();
                if ($Query) {
                    return response()->json(array("success" => "Félicitations, Association à été supprimée avec succès."));
                }
            }
        } else {
            return response()->json(array("errors" => "Oops ! Assurez-vous de remplir tous les champs !"));
        }
    }
}
