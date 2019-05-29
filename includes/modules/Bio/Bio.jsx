// External Dependencies
import React, { Component , Fragment} from 'react';

// Internal Dependencies
import './style.css';

function BioPhoto(props) {
  if(undefined===props.image){
    return '';
  }
return  <div className="bio-photo">
  <div className="bio-photo-wrapper">
    <a href={props.url} target="_new"><img src={props.image}  alt={props.alt} className="loadafter" /></a>
  </div>
</div>
}
function SocialBox(props){
  if(undefined===props.account || ""===props.account){
    return '';
  }
  return <div className="social-box">
  <a href={props.url + props.account}  target="_blank" rel="noopener noreferrer">
    <i title={props.iconTitle} className={props.iconClass}></i>
  </a>
</div>
}

class Bio extends Component {

  static slug = 'divicf_bio';
  constructor() {
    super();
    this.state = { data: { direct_phone:'', url:"/", firstName:""} };
  }
  fetchData(id){
    fetch('/wp-json/divieuc/v1/bio_profile/' + id)
    .then(res => res.json())
    .then(json => {this.setState({ data: json.data });});
  }
  componentDidMount() {
    this.fetchData(this.props.bio);
  }
  componentDidUpdate(prevProps) {
    // Typical usage (don't forget to compare props):
    if (this.props.bio !== prevProps.bio) {
      this.fetchData(this.props.bio);
    }
  }
  changeBio(){
    return "bio: " + this.props.bio; 
    
  }

  render() {
    //const Content = this.props.content;
    //console.log(this);
    return ( 
      <Fragment>
        <div className="card-container">
        <BioPhoto image={this.state.data.image} url={this.state.data.url} alt={this.state.data['image-alt']} />

  <div className="bio-name">
     {this.state.data.name} 
  </div>
  <div className="bio-title">
  {this.state.data.job_title}
  </div>
  <div className="bio-leadership">
    
  </div>
  
  <div className="bio-social">
  <SocialBox url="mailto:" account={this.state.data.user_email} iconClass="fa fa-envelope circle" iconTitle="email Link" />
  <SocialBox url="https://twitter.com/" account={this.state.data.twitter} iconClass="fa fa-twitter-square circle" iconTitle="twitter Link" />
  <SocialBox url="https://facebook.com/" account={this.state.data.facebook} iconClass="fa fa-facebook-square circle" iconTitle="facebook Link" />
  <SocialBox url="https://www.linkedin.com/in/" account={this.state.data.linkedin} iconClass="fa fa-linkedin-square circle" iconTitle="linkedin Link" />
  </div>
  <div className="bio-phone">
    <a href={'tel:' + this.state.data.direct_phone.replace(/\D/g, '')} className="phone">{this.state.data.direct_phone}</a>
  </div>
  <div className="bio-description">
  <p> { this.state.data.description }</p>
  </div>
  <div className="bio-about">
  <a className="et_pb_button et_pb_more_button" href={this.state.data.url}>Read {this.state.data.firstName}'s Full Bio</a>
  </div>
</div>     
        
      </Fragment>
    );
  }
}

export default Bio;
