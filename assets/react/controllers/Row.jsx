import React from 'react';

export default function (props) {

    console.log(props)
    return <div className="row">
        <div className="col-xl-6">
            <div className="card">
                <div className="card-header">
                    <h4 className="card-title mb-0">Irregular Timeseries Chart</h4>
                </div>

                <div className="card-body">
                    <div id="area_chart_irregular" data-colors='["--vz-primary", "--vz-warning", "--vz-success"]'
                         className="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>

        <div className="col-xl-6">
            <div className="card">
                <div className="card-header">
                    <h4 className="card-title mb-0">Area Chart With Null Values Chart</h4>
                </div>

                <div className="card-body">
                    <div id="area-missing-null-value" data-colors='["--vz-success"]' className="apex-charts"
                         dir="ltr"></div>
                </div>
            </div>
        </div>
        <div>
            {props.children}
            {props.test}
        </div>
    </div>
}

