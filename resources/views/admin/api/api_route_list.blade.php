<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{{ asset('assets/img/Proposed.jpg')}}" rel="icon">

<title>Bible Production Info - Version 1 [Dev-APIs] - Webservice Form</title>

<style type="text/css">
    body {
        font-size: 16px;
        color: black;
    }

    td {
        padding-top: 5px;
        padding-left: 5px;
    }
</style>


</head>

<body>
    <h1 class="page-title" style="color:#7367EF !important">Bible Production Info API  - Version 1 [Dev-APIs] - Webservice
        Form - Last Update (13-05-2025)</h1>
    <br>

    <fieldset style="border:2px solid; border-color:#7367EF">
        <form method="POST" action="{{ url('api/get_dictionary_words_api') }}">
            @csrf
            <table border="0" width="100%">
                <tr>
                    <td height="30" colspan="2" align="left">
                        <strong style="text-decoration:underline;color:#F00;">1 . Get Words Info Using App Version ID [Development Mode]</strong><br>
                        <div><strong>API URL:</strong> {{ url('api/get_dictionary_words_api') }}</div>
                        <div><strong>Method:</strong> POST</div>
                        <div><strong>Content-Type:</strong> application/x-www-form-urlencoded</div>
                        <div><strong>API Mode:</strong> Development</div>
                        <div><strong>Notes:</strong> Last Modified at: <span style="color:#7367EF;">05-AUGUST-2024</span></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <table width="100%" border="0" cellspacing="2" cellpadding="2">
                            <tr style="background-color:#7367EF; color:#FFF;">
                                <td><strong>Label Name</strong></td>
                                <td><strong>Value</strong></td>
                                <td><strong>Variable Name</strong></td>
                                <td><strong>Mandatory</strong></td>
                                <td><strong>Note</strong></td>
                                <td><strong>Sample</strong></td>
                            </tr>

                            <tr>
                                <td>Get App Id</td>
                                <td><input type="text" name="app_id" /></td>
                                <td>app_id</td>
                                <td>Yes</td>
                                <td>From Apps List API from GetAppInfo</td>
                                <td>1 (string)</td>
                            </tr>

                            <tr>
                                <td>Book Number</td>
                                <td><input type="text" name="book_num" /></td>
                                <td>book_num</td>
                                <td>Yes</td>
                                <td>From the Book list API</td>
                                <td>1 (string)</td>
                            </tr>

                            <tr>
                                <td>Chapter Number</td>
                                <td><input type="text" name="chapter_num" /></td>
                                <td>chapter_num</td>
                                <td>Yes</td>
                                <td>From Book List API</td>
                                <td>1 (string)</td>
                            </tr>

                            <tr>
                                <td colspan="6" align="center">
                                    <input type="submit" value="Submit" />
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
    <br><br>


</body>

</html>
