import React,{useEffect,useState} from 'react';
const Helpers = require('../../../../../helpers/Helpers');

const DetailedResultCard = (props) => {
  
  const [sections,setSections] = useState([]);
  
  
  useEffect( () => {
    setSections(props.sections);
  },[props.sections]);
  
  
    return (
        <div className="pricing-card animate-up-2 detailed-page">
            <div className={`card shadow border-${props.color} p-0 result-heading group mb-5 mt-5`}>
                <header className="card-header bg-white text-center">
                  <div className={"icon-title"}>
                    <h1 className="mb-3 font-weight-bolder group-title">{props.group}</h1>
                    <span>
                        <i className={`fa fa-${props.icon} fa-4x icon-${props.color}`}> </i>
                    </span>
                  </div>
                    <span className={"pt-3 description"}>{props.description}</span>
                </header>
            </div>

            <div className="recommendations">
                {
                    props.sections.map( (section,index ) => {
                      return (
                        <div className={`card shadow b border-${props.color} p-0`} key={index}>
                          <header className={`bg-${props.color} text-center text-white`}>
                            <h2>{section.name}</h2>
                            <span>{section.description}</span>
                          </header>
                          <div className="card-body">
                            
                            {
                              section.answer_recommendations.map( (recommendation,i) => {
                                return ((recommendation.recommendation.length > 0)?
                                  <p className={ `border-bottom pb-2 border-${props.color} m-0` }>
                                    {recommendation.recommendation}
                                  </p>:'')
                              }
                              )
                            }
                          </div>
                          
                      </div>
                      )
                    })
                }
              {/*<p key={i} className={`${i !== section.answer_recommendations.length + 1 ? `border-bottom pb-2 border-${props.color}` : null} m-0`}>*/}
                {/*{Helpers.titleCase((recommendation.recommendation)?recommendation.recommendation:'Display recommendation here')}*/}
              {/*</p>*/}
            </div>
        </div>

    )};

export default DetailedResultCard;
