# Personalized BDM Mechanism for Effcient Market Intervention Experiments

- I Arrieta-Ibarra, J Ugander (2018)
[A Personalized BDM Mechanism for Efficient Market Intervention Experiments](https://dl.acm.org/citation.cfm?id=3219220) Proc. 19th ACM Conf. on Economics and Computation (EC). ([slides](https://stanford.edu/~jugander/papers/ec18-pbdm-slides.pdf))

Abstract:
The BDM mechanism, introduced by Becker, DeGroot, and Marschack in the 1960’s, employs a second-price
auction against a random bidder to elicit the willingness to pay of a consumer. The BDM mechanism has
been recently used as a treatment assignment mechanism in order to estimate the treatment effects of policy
interventions while simultaneously measuring the demand for the intervention. In this work, we develop a
personalized extension of the classic BDM mechanism, using modern machine learning algorithms to predict
an individual’s willingness to pay and personalize the “random bidder” based on covariates associated with
each individual. We show through a mock experiment on Amazon Mechanical Turk that our personalized
BDM mechanism results in a lower cost for the experimenter, provides better balance over covariates that are
correlated with both the outcome and willingness to pay, and eliminates biases induced by ad-hoc boundaries
in the classic BDM algorithm. We expect our mechanism to be of use for policy evaluation and market
intervention experiments, in particular in development economics. Personalization can provide more efficient
resource allocation when running experiments while maintaining statistical correctness.

# Experiment

The experiment folder contains the files that create the causal-learning website used for running the experiment in Mechanical Turk

# Analysis

The src folder contains the analysis from the data collected from the experiment. 

