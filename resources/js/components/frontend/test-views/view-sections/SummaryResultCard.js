import React,{useEffect} from 'react';
const Helpers = require('../../../../helpers/Helpers');

const SummaryResultCard = (props) => {
    return (
        <div className="pricing-card animate-up-2">
            <div className={`card shadow border-${props.color} p-0`}>
                <header className="card-header bg-white text-center pt-6">
                        <span>
                            <i className={`fa fa-${props.icon} fa-5x icon-${props.color}`}> </i>
                        </span>
                    <h1 className="text-gray-800 mb-3 font-weight-bolder mt-3">{props.group}</h1>
                  <p className={`text-${props.color}`} style={{ padding: 0.5+'rem',fontWeight:'bolder' }}>{props.description}</p>
                </header>
                <div className="card-body p-0">
                    <div className="container text-center mb-3">
                        {
                            props.sections
                                .map((section, index) => {
                                        return (
                                          (section.recommendation && section.recommendation !== '') &&
                                          <p key={Math.round(Math.random()*100) + index}
                                            className={`${index !== props.sections.length + 1 ? `border-bottom pb-2 border-${props.color}` : null} m-0`}>
                                            {(section.recommendation)?section.recommendation:''}
                                          </p>
                                        )
                                    }
                                )
                        }
                    </div>
                </div>
                {/*<div className={`d-flex justify-content-center card-footer bg-${props.color}`}>*/}
                {/*<span className="d-block text-white ">*/}
                {/*<span className="display-1 font-weight-bold">*/}
                {/*{props.score}<span className="align-middle font-medium">%</span>*/}
                {/*</span>*/}
                {/*</span>*/}
                {/*</div>*/}
            </div>
        </div>
    );
};

export default SummaryResultCard;
