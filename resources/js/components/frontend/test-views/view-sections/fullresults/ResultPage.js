import React, {useEffect,useState,Fragment} from 'react';
import axios from 'axios';
import config from '../../../../../helpers/Config';
import PageHeadingSection from "./PageHeadingSection";
import CelebrationImage from "../../../../assets/images/illustrations/result-celebration.svg";
import DetailedCardsSection from "./DetailedCardsSection";
import DetailedResultCard from "./DetailedResultCard";
import PayHeadingSection from "./PayHeadingSection";
import Paystack from "./Paystact";
import MenuItem from "@material-ui/core/MenuItem";



const ResultPage = (props) => {
  const returnToken = () => {return JSON.parse(localStorage.getItem('@AppT4k3n'));};
    const [flatRate,setFlatRate] = useState(0);
    const [results,setResults]   = useState([]);
    const [paid,setPaid]         = useState(false);
    const [loading,setLoading]   = useState(false);
    const [reload,setReload]     = useState(false);
    
    
    useEffect( () => {
      const currentSession = localStorage.getItem('@TstS3ssion');
      axios.get(config.apiBaseUrl+`tests/results/${currentSession}`,{
          headers:{
              Authorization: `Bearer ${returnToken()}`
          }
      }).then( res => {
          if (res.data.status === false && res.data.message === 'non_payment'){
              setPaid(false);
          } else if(res.data.status === true){
              setResults(res.data.data);
              setPaid(true);
              setLoading(false);
          }else {
              alert("Could not retrieve result for this session, Please reload");
              props.history.push('/auth/register');
          }
      }).catch( err => {
          console.log(err);
      });
      getFlatRate();
  },[getFlatRate, paid, props.history]);
  
  const getFlatRate = async () => {
        await axios.get(config.apiBaseUrl+`settings`,{
            headers:{
                Authorization: `Bearer ${returnToken()}`
            }
        }).then(res => {
            let flat_rate = res.data.find( rate => rate.name === "PRIVATE_LEARNER_FLAT_RATE").value;
            setFlatRate(flat_rate);
        }).catch(err => {
            console.log(err);
        });
    };
  
  const hasPaid = () => {
    setPaid(true);
  }
  
  const handlePrint = () => {
    const currentSession = localStorage.getItem('@TstS3ssion');
    if (currentSession){
      props.history.replace('/results/'+currentSession);
    }
  }
  
  const fullResults = () => {
        return (<section>
            <PageHeadingSection
                headingImage={CelebrationImage}
                pageTitle={"Recommendations"}
                pageTitleColor={"secondary"}
                pb={8}>
            </PageHeadingSection>
            <DetailedCardsSection>
                {renderDetailedCards()}
            </DetailedCardsSection>
          <div className="container">
            <div className="row justify-content-center">
              <div className="col-md-5">
                <button className="btn btn-primary" onClick={handlePrint}>
                  <i className={'fa fa-print'}/>  Print Result
                </button>
              </div>
            </div>
          </div>
        </section>)
    };
  
  const renderDetailedCards = () => {
        return results.map( (result,index) =>
                (result.sections.length > 0)?
                    <DetailedResultCard
            key={result + index}
            group={result.group_name}
            description={result.description}
            sections={result.sections}
            icon={result.icon}
            color={result.color}
            score={result.percentage}
        />:''
        )
    };
  
  const payForResult  = () => {
        return (
            <Fragment>
                <section>
                    <PayHeadingSection
                        headingImage={CelebrationImage}
                        pageTitle={"Congratulations!"}
                        pageTitleColor={"secondary"}
                        pb={8}>
                        <h2>Your Results are Ready!</h2>
                        <h1>Please pay the Sum of &#8358;{ flatRate } to View,Download & Email the Complete Result</h1>
                    </PayHeadingSection>
                    <DetailedCardsSection>
                        <div className="w-50 pay-btn">
                            <Paystack rate={flatRate} hasPaid={hasPaid}/>
                        </div>
                    </DetailedCardsSection>
                </section>
            </Fragment>
        );
    };
  
  return (
      <main>
          { (paid === true)? fullResults():payForResult()}
      </main>
    );
}

export default ResultPage;
