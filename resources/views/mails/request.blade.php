<!DOCTYPE html>
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <style type="text/css">
      .mb-0 {
          margin-bottom: 0 !important
      }

      .mb-1 {
          margin-bottom: .25rem !important
      }

      .mb-2 {
          margin-bottom: .5rem !important
      }

      .mb-3 {
          margin-bottom: 1rem !important
      }

      .mb-4 {
          margin-bottom: 2rem !important
      }

      .mb-5 {
          margin-bottom: 4rem !important
      }

      .mb-auto {
          margin-bottom: auto !important
      }

      .my-0 {
          margin-top: 0 !important;
          margin-bottom: 0 !important
      }

      .my-1 {
          margin-top: .25rem !important;
          margin-bottom: .25rem !important
      }

      .my-2 {
          margin-top: .5rem !important;
          margin-bottom: .5rem !important
      }

      .my-3 {
          margin-top: 1rem !important;
          margin-bottom: 1rem !important
      }

      .my-4 {
          margin-top: 2rem !important;
          margin-bottom: 2rem !important
      }

      .my-5 {
          margin-top: 4rem !important;
          margin-bottom: 4rem !important
      }

      .my-auto {
          margin-top: auto !important;
          margin-bottom: auto !important
      }

      table tbody tr th {
        text-align: start;
      }
    </style>
  </head>

  <body class="p-2">
    <!-- <p class="mb-4">Cher(e) {{ @$details->ClientName }},</p> -->
    <p class="mb-4">Bonjour,</p>

    <p>
      {{ @$details->TypeName }}
    </p>

    <div class="table-responsive">
      <table class="table table-bordered align-middle" style="width: 100%">
        <thead>
          <tr>
            <th colspan="2" style="text-align: center;">Voici les informations</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <th>Nom et Prénom</th>
              <td style="text-align: right;">{{ @$details->ClientName }}</td>
            </tr>
            <tr>
              <th>Type</th>
              <td style="text-align: right;">{{ @$details->TypeVacancy }}</td>
            </tr>
            <tr>
              <th>Nombre de jours</th>
              <td style="text-align: right;">{{ @$details->NumDays }}</td>
            </tr>
            <tr>
              <th>Opération</th>
              <td style="text-align: right;">{{ @$details->TimeOf }}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td style="text-align: right;">{{ @$details->Status }}</td>
            </tr>
            <tr>
              <th>Date de sortie</th>
              <td style="text-align: right;">{{ @$details->StartDate }}</td>
            </tr>
            <tr>
              <th>Date d’entrée</th>
              <td style="text-align: right;">{{ @$details->EndDate }}</td>
            </tr>
        </tbody>
      </table>
    </div>

    <p class="mt-4">Nous étudierons votre demande et reviendrons vers vous prochainement. Merci de votre compréhension.</p>
    <p class="mb-0"><strong>Cordialement,</strong></p>

  </body>
</html>