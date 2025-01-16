@foreach ($costbid as $bid)

    <div class="row">
        <div class="col-md-6">
            <h5 class="font-weight-bold">Document Information</h5>
            <table class="table table-borderless">
                <tr>
                    <td>Code</td>
                    <td>: {{ $bid->code }}</td>
                </tr>
                <tr>
                    <td>Document Date</td>
                    <td>: {{ $bid->document_date }}</td>
                </tr>
                <tr>
                    <td>Bid Date</td>
                    <td>: {{ $bid->bid_date }}</td>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>: {{ $bid->project_name }}</td>
                </tr>
            </table>
        </div>
    </div>
    
@endforeach