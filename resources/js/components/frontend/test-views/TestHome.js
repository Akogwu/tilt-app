import React, {Component} from 'react';
import PageHeadingSection from "../../components/sections/PageHeadingSection";
import PageHeadingImage from "../../assets/images/illustrations/Student.svg"
import EvaluationStagesSection from "../../components/sections/evaluation-stages/EvaluationStagesSection";
import PageHeadingButton from "../../components/snippets/PageHeadingButton";
import SectionHeading from "../../components/sections/SectionHeading";
import axios from 'axios';
import { Spinner} from "react-bootstrap";
import config from '../../../helpers/Config';


class TestHome extends Component {

    state = {
        loading : false,
        allTests: [],
        user:false
    };

    
     newTestSession = () => {
        this.setState({loading:true});
        const userProfile = JSON.parse(localStorage.getItem('@UserProfile'));
        const user = {};
         if (userProfile) { user.user_id = userProfile.id }else { user.user_id = '' }
          axios.post(config.apiBaseUrl+`test/new-session`,user).then( res => {
                if(res.status){
                    this.setState({loading:false});
                    localStorage.setItem('@TstS3ssion',res.data.session_id);
                    this.props.history.push("/test/take-test")
                }  else {
                this.setState({loading:false});
                  alert("Could not create session, Please retry")
                }
           }).catch( err => {
            this.setState({loading:false});
                console.log(err);
                alert("Error creating session, Please retry")
           });
    };

    showSpinner = (size = "lg", color = "secondary") => (
        <Spinner
            animation="grow"
            size={size}
            aria-hidden="true"
            variant={color}
        />
    );
    
    render() {
        return (
            <main>
                <PageHeadingSection textColor={"primary"} headingImage={PageHeadingImage}>
                    <h1 className="font-weight-bold text-gray display-1">Welcome To The Test</h1>
                     <h3 className="font-weight-light">Together we will find the cause of each learning deficiency</h3>
                    <div  className="d-flex justify-content-center">
                    {this.state.loading ? this.showSpinner("lg") :
                        <PageHeadingButton
                        onClick={this.newTestSession}
                        text={"Begin The Test"}
                        icon={"fa-arrow-right"}
                        color={"secondary"}
                    />}
                    </div>
                    <h3 className="pt-4 mb-0 ">Patiently answer every question honestly</h3>
                    <p className="lead pt-0">Ask your teacher or guardian to explain any question you do not clearly understand</p>
                  
                    <SectionHeading
                        renderHeading={() => "How the test works!"}
                        renderDescription={() => "The following are the various stages of our assessment"}
                        pb={7}
                        pt={7}
                    />
                </PageHeadingSection>
                <EvaluationStagesSection />
                <div className="d-flex justify-content-center pb-8 pt-lg-4">
                {this.state.loading ? this.showSpinner("lg") :<PageHeadingButton
                        onClick={this.newTestSession}
                        text={"Begin The Test"}
                        icon={"fa-arrow-right"}
                        color={"secondary"}
                    />}
                </div>
            </main>
        );
    }
}

export default TestHome;
