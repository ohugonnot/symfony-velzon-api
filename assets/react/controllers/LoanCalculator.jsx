import React, {useState} from 'react';

const rate24MonthsLessThan2000 = 5.041
const rate36MonthsLessThan2000 = 3.789
const rate48MonthsLessThan2000 = 3.033
const rate60MonthsLessThan2000 = 2.543

const rate24MonthsLessThan5000 = 4.78
const rate36MonthsLessThan5000 = 3.415
const rate48MonthsLessThan5000 = 2.692
const rate60MonthsLessThan5000 = 2.241

const rate24MonthsLessThan10000 = 4.695
const rate36MonthsLessThan10000 = 3.369
const rate48MonthsLessThan10000 = 2.645
const rate60MonthsLessThan10000 = 2.193

const rate24MonthsLessThan100000 = 4.695
const rate36MonthsLessThan100000 = 3.324
const rate48MonthsLessThan100000 = 2.598
const rate60MonthsLessThan100000 = 2.145

function getContextualRate(amount, duration) {
    let rate;
    if (amount <= 2000) {

        duration == "24" ? rate = rate24MonthsLessThan2000 : 0;
        duration == "36" ? rate = rate36MonthsLessThan2000 : 0;
        duration == "48" ? rate = rate48MonthsLessThan2000 : 0;
        duration == "60" ? rate = rate60MonthsLessThan2000 : 0;

    } else if (amount > 2000 && amount <= 5000) {
        duration == "24" ? rate = rate24MonthsLessThan5000 : 0;
        duration == "36" ? rate = rate36MonthsLessThan5000 : 0;
        duration == "48" ? rate = rate48MonthsLessThan5000 : 0;
        duration == "60" ? rate = rate60MonthsLessThan5000 : 0;
    } else if (amount > 5000 && amount <= 10000) {
        duration == "24" ? rate = rate24MonthsLessThan10000 : 0;
        duration == "36" ? rate = rate36MonthsLessThan10000 : 0;
        duration == "48" ? rate = rate48MonthsLessThan10000 : 0;
        duration == "60" ? rate = rate60MonthsLessThan10000 : 0;
    } else {
        duration == "24" ? rate = rate24MonthsLessThan100000 : 0;
        duration == "36" ? rate = rate36MonthsLessThan100000 : 0;
        duration == "48" ? rate = rate48MonthsLessThan100000 : 0;
        duration == "60" ? rate = rate60MonthsLessThan100000 : 0;
    }

    console.log('rate', rate)
    return rate

}

export default function (props) {
    const [duration, setDuration] = useState(24)
    const [buyPrice, setBuyPrice] = useState(0.0)

    let contextualRate = getContextualRate(buyPrice, duration) * duration
    let totalCost = buyPrice * (contextualRate / 100)
    let costPerMonth = totalCost / duration

    const handleSubmit = (e) => {
        e.preventDefault()
        console.log("------")
        console.log('buyPrice', buyPrice)
        console.log('duration', duration)
        console.log('contextualRate', contextualRate)
        console.log('totalCost', totalCost)
        console.log('costPerMonth', costPerMonth)
    }


    return (<div className="row">
        <h1>Loan Calculator</h1>
        <div className="container-fluid">
            <div className="card card-body col col-5">
                <form onSubmit={handleSubmit} id={'loan-calculator-form'}>

                    <div className={'row'}>
                        <label htmlFor={'p-achat'}>Valeur achat</label>
                        <input onChange={(e) => setBuyPrice(parseFloat(e.target.value))} value={buyPrice} id={'p-achat'}
                               type="number"/>{buyPrice}
                    </div>
                    <div className={'row'}>
                        <label htmlFor="duration">Durée</label>
                        <select onChange={(e) => setDuration(parseInt(e.target.value))} value={duration} name="duration"
                                id="duration">
                            <option value="24">24 mois</option>
                            <option value="36">36 mois</option>
                            <option value="48">48 mois</option>
                            <option value="60">60 mois</option>
                        </select>
                    </div>
                    <div className={'row'}>
                        <button className={'btn btn-primary btn-sm'} id={'submit-btn'} type={"submit"}>Calculer</button>
                    </div>
                    <div>p achat: {buyPrice}</div>
                    <div>durée: {duration}</div>
                    <div>Taux context: {contextualRate}</div>
                    <div>cout mensuel: {costPerMonth}</div>
                    <div>cout total: {totalCost}</div>
                </form>
            </div>


        </div>
        <div>
            {props.children}
            {props.test}
        </div>
    </div>)
}

