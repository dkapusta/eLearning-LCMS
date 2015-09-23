###########################################################################
# evaluation-script.R                                                     #
#                                                                         #
# Comparing Anomaly Detectors for Keystroke Biometrics                    #
# Evaluation Proceedure                                                   #
# R Script                                                                #
#                                                                         #
# by: Kevin Killourhy                                                     #
# date: May 19, 2009                                                      #
###########################################################################

sink("/dev/null");
library( MASS );
args <- commandArgs(trailingOnly = TRUE)

mahalanobisTrain <- function( YTrain ) {
  print(YTrain)
  dmod <- list( mean  = colMeans( YTrain ),
                covInv = ginv( cov( YTrain ) ) );
  return( dmod );
}

datafile <- paste("./components/biometrics/ajax/data", args[1], sep="/");
if( ! file.exists(datafile) )
  stop( "Password data file ", datafile, " does not exist");
password.timing.df <- read.csv( datafile, header = TRUE );

relevant.timing.data = subset( password.timing.df,
                               select = -c( repetition ) )
YTrain <- as.matrix( relevant.timing.data );
detection.model <- mahalanobisTrain( YTrain );
serialized.form <- rawToChar( serialize(detection.model, NULL, ascii=TRUE) )

sink();
write(serialized.form, "")