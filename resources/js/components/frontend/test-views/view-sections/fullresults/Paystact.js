import React,{useState,useEffect,Fragment} from 'react';
import { usePaystackPayment} from 'react-paystack';
import Logo from './paystack_logo.png';
import NumberFormat from 'react-number-format';
import { withRouter } from 'react-router';

const Paystack = (props) => {
    const [state,setState] = useState({
        email:'noemail@tilt.com',
        payment_type:'test_result',
        user_id:'',
        quantity:1,
        payment_for:'',
        flat_rate:''
    });
    
    
    
    useEffect( () =>{
        let user = JSON.parse(localStorage.getItem('@UserProfile'));
        if (user){
            const {id,email} = user;
            const currentSession = localStorage.getItem('@TstS3ssion');
            setState({...state,email,user_id:id,payment_for:currentSession});
        }else {
            props.history.push('/');
        }
    },[]);

    const config = {
        reference: (new Date()).getTime(),
        email: state.email,
        amount: parseInt(props.rate)*100,
        metadata: {
            custom_fields:[
                {variable_name:'payment_type', value:state.payment_type, display_name: 'Payment Type'},
                {variable_name:'payment_for', value:state.payment_for, display_name: 'Payment For'},
                {variable_name:'user_id', value:state.user_id,display_name: 'User Id'},
                {variable_name:'quantity', value:state.quantity,display_name: 'Quantity'},
            ]
        },
        callback: (response) =>{
            var reference = response.reference;
            alert('Payment complete! Reference: ' + reference);
        },
        onSuccess: () =>{
            console.log('successful');
            setState({ });
            console.log(props.hasPaid,'There');
            props.hasPaid();
        },
        publicKey: 'pk_test_8e883472a3c7791d253b405964cd45013f816b19',
    };
    
    
    const initializePayment = usePaystackPayment(config);
    

    const handleChangeAmount = (e) => {
        setState({...state,[e.target.name]:e.target.value, amount:e.target.value*state.flat_rate});
    };
    return (
        <Fragment>
            <header className="App-header pt-10">
                <div className={"card d-none"}>
                    <div className="card-body">
                        <input type={'number'} name={"quantity"} onChange={handleChangeAmount} className={"form-control"} min={1} placeholder={'Enter Number of Students'}/>
                    </div>
                </div>
                <img src={Logo} alt=""/>
            </header>
            <button className={"btn btn-success btn-block mb-6"}  onClick={() => { initializePayment( () =>{
                props.hasPaid();
            } )}}>  Pay &#8358;{<NumberFormat displayType={'text'} value={Number.parseFloat(props.rate).toFixed(2)} thousandSeparator={true} />} Now </button>
        </Fragment>
    );
};

export default withRouter(Paystack);