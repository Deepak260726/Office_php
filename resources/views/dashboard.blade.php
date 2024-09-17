@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
  <div class="container">
    <div class="row page-header">
      <h1 class="float-left page-title">
        @include('modules.page-title')
      </h1>
      <span class="float-right page-controller" style="margin-left: auto;">
        <button type="submit" class="btn btn-outline-primary btn-md">Deposit</button>
        <button type="submit" class="btn btn-outline-primary btn-md">New Report</button>
        <button type="submit" class="btn btn-outline-primary btn-md">Exctract Data</button>
        <button type="submit" class="btn btn-outline-success btn-md">New Receipt</button>
      </span>
    </div>
  </div>

  <div class="col-12 px-0">
    <div class="card">
      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap table-hover table-sm table-multi-row">
          <caption></caption>
          <thead>
            <tr>
              <th scope="col" class="w-1">Receipt Id</th>
              <th scope="col">Location</th>
              <th scope="col">Mode</th>
              <th scope="col" class="text-center">Coll. Date</th>
              <th scope="col" class="text-center">Dep. Date</th>
              <th scope="col"><div>Chq / DD Nb.</div><small class="text-muted">Chq / DD Date</small></th>
              <th scope="col"><div>Inv Number</div><small class="text-muted">BOL Nb.</small></th>
              <th scope="col"><div>Inv Party Name</div><small class="text-muted">Inv Party Code</small></th>
              <th scope="col" class="text-center">Curr.</th>
              <th scope="col" class="text-center">Print</th>
              <th scope="col" class="text-right">Receipt Amt</th>
              <th scope="col" class="text-right">Advance Amt</th>
              <th scope="col" class="text-right"><div>Applied Amt</div><small class="text-muted">Invoice Amt</small></th>
            </tr>
          </thead>
          <tbody>
            <tr class="my-3">
              <td class="text-center">
                <input class="form-control form-control-sm" name="search_receipt_id" placeholder="Receipt Id" type="text">
              </td>
              <td>
                <select class="form-control form-control-sm">
                  <option>- All -</option>
                  <option>CHENNAI</option>
                </select>
              </td>
              <td>
                <select class="form-control form-control-sm">
                  <option>- All -</option>
                </select>
              </td>
              <td class="text-center">
                <input class="form-control form-control-sm" name="search_receipt_id" placeholder="Coll Date" type="text">
              </td>
              <td class="text-center">
                <input class="form-control form-control-sm" name="search_receipt_id" placeholder="Dept Date" type="text">
              </td>
              <td class="text-center">
                <input class="form-control form-control-sm" name="search_receipt_id" placeholder="Cheque or DD Nb." type="text">
              </td>
              <td class="text-center">
                <input class="form-control form-control-sm" name="search_receipt_id" placeholder="Invoice or BOL Nb." type="text">
              </td>
              <td class="text-center">
                <input class="form-control form-control-sm" type="text" placeholder="Partner Code">
              </td>
              <td>
                <select class="form-control form-control-sm">
                  <option> - </option>
                  <option>INR</option>
                  <option>USD</option>
                </select>
              </td>
              <td>
                <select class="form-control form-control-sm">
                  <option> - </option>
                  <option>Y</option>
                  <option>N</option>
                </select>
              </td>
              <td class="text-right" colspan="3">
                <button type="submit" class="btn btn-md o-button-grey"><em class="fe fe-x"></em> Clear</button>
                <button type="submit" class="btn btn-outline-info btn-md o-button"><em class="fe fe-search"></em> Search</button>
              </td>
            </tr>
            <tr class="my-3"><td class="text-center"><a href="http://10.13.40.221/e-helpdesk/Finance/InvoiceReceipt/View/Receipt/411177">411177</a></td><td>TUTICORIN</td><td>Demand Draft</td><td class="text-center">21-Jul-18</td><td class="text-center"><div>-</div><img alt="" src="{{ asset('/images/banks/hdfc-bank.png') }}" width="15" height="15"></td><td><div>806060</div><small class="text-muted">21-Jul-18</small></td><td><div>INITN031240</div><small class="text-muted">LGS0134906A</small></td><td><div>ABAAN IMPEX PRIVATE LIMIT...</div><small class="text-muted">0000000010</small></td><td class="text-center align-middle text-success"><em class="fa fa-rupee"></em></td><td class="text-center align-middle"><em class="fe fe-printer text-primary" data-toggle="tooltip" title="Receipt Printed" data-original-title="Receipt Printed"></em></td><td class="text-right">145,217.00</td><td class="text-right">0.00</td>
            <td class="text-right"><div>32,958.00</div><small class="text-muted">32,958.00</small></td>
            </tr>
            <tr class=""><td class="text-center"><a href="http://10.13.40.221/e-helpdesk/Finance/InvoiceReceipt/View/Receipt/411177">411177</a></td><td>TUTICORIN</td><td>Demand Draft</td><td class="text-center">21-Jul-18</td><td class="text-center"><div>-</div><img alt="" src="{{ asset('/images/banks/deutsche-bank.jpg') }}" width="15" height="15"></td><td><div>806060</div><small class="text-muted">21-Jul-18</small></td><td><div>INITN033833</div><small class="text-muted">LGS0134906A</small></td><td><div>ABAAN IMPEX PRIVATE LIMIT...</div><small class="text-muted">0000000010</small></td><td class="text-center align-middle text-success"><em class="fa fa-rupee"></em></td><td class="text-center align-middle"><em class="fe fe-printer text-muted" data-toggle="tooltip" title="Receipt not Printed" data-original-title="Receipt  not Printed"></em></td><td class="text-right">112,259.00</td><td class="text-right">0.00</td><td class="text-right"><div>112,259.00</div><small class="text-muted">112,259.00</small></td></tr>

            <tr class=""><td class="text-center"><a href="http://10.13.40.221/e-helpdesk/Finance/InvoiceReceipt/View/Receipt/411176">411176</a></td><td>TUTICORIN</td><td>Demand Draft</td><td class="text-center">21-Jul-18</td><td class="text-center"><div>22-Jul-18</div><img alt="" src="{{ asset('/images/banks/hsbc-bank.png') }}" width="20" height="15"></td><td><div>000768</div><small class="text-muted">21-Jul-18</small></td><td><div>INITN033826</div><small class="text-muted">LPL0813114</small></td><td><div>ABAAN IMPEX PRIVATE LIMIT...</div><small class="text-muted">0000000011</small></td><td class="text-center align-middle text-danger"><em class="fa fa-dollar"></em></td><td class="text-center align-middle"><em class="fe fe-printer text-muted" data-toggle="tooltip" title="Receipt not Printed" data-original-title="Receipt  not Printed"></em></td><td class="text-right">121,478.00</td><td class="text-right">0.00</td><td class="text-right"><div>121,478.00</div><small class="text-muted">121,478.00</small></td></tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
@endsection
